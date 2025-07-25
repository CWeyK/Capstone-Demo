import json
import gymnasium as gym
from gymnasium import spaces
import numpy as np
from collections import defaultdict

class SchedulingEnv(gym.Env):
    def __init__(self, dataset_path):
        super(SchedulingEnv, self).__init__()

        # Load dataset
        with open(dataset_path, 'r') as f:
            self.data = json.load(f)

        self.classes = self.data['classes']
        self.rooms = self.data['rooms']
        self.num_classes = len(self.classes)
        self.num_rooms = len(self.rooms)

        self.days = 5
        self.slots_per_day = 10
        self.total_slots = self.days * self.slots_per_day

        self.max_actions = self.num_rooms * self.total_slots
        self.action_space = spaces.Discrete(self.max_actions)

        # Flattened observation shape
        self.obs_dim = 3 + self.total_slots * self.num_rooms + self.num_rooms
        self.observation_space = spaces.Box(
            low=0.0,
            high=1.0,
            shape=(self.obs_dim,),
            dtype=np.float32
        )

        self.reset()

    def reset(self, *, seed=None, options=None):
        super().reset(seed=seed)
        if seed is not None:
            np.random.seed(seed)

        self.current_class_idx = 0
        self.room_slot_occupancy = np.zeros((self.num_rooms, self.total_slots), dtype=bool)
        self.student_schedule = defaultdict(set)
        self.lecturer_schedule = defaultdict(set)
        self.schedule = [None for _ in range(self.num_classes)]

        self.student_day_slots = defaultdict(lambda: defaultdict(list))
        self.lecturer_day_slots = defaultdict(lambda: defaultdict(list))


        return self._get_observation(), {}

    def _get_observation(self):
        if self.current_class_idx >= self.num_classes:
            # Return a dummy zero observation if all classes are scheduled
            return np.zeros(self.obs_dim, dtype=np.float32)

        obs = np.zeros(self.obs_dim, dtype=np.float32)

        class_ = self.classes[self.current_class_idx]
        obs[0] = class_["duration"] / self.slots_per_day
        obs[1] = len(class_["students"]) / 100.0  # adjust based on actual max
        obs[2] = 1.0  # optional bias or flag

        offset = 3
        # Occupancy map 
        for room_id in range(self.num_rooms):
            for slot in range(self.total_slots):
                if self.room_slot_occupancy[room_id][slot]:
                    obs[offset + room_id * self.total_slots + slot] = 1.0

        # Capacity mask
        offset += self.total_slots * self.num_rooms
        if self.current_class_idx < self.num_classes:
            class_ = self.classes[self.current_class_idx]
            class_size = len(class_["students"])
            for room_id in range(self.num_rooms):
                capacity = self.rooms[room_id]["capacity"]
                obs[offset + room_id] = 1.0 if capacity >= class_size else 0.0

        return obs


    def step(self, action):
        if self.current_class_idx >= self.num_classes:
            return self._get_observation(), 0.0, True, False, {}

        class_ = self.classes[self.current_class_idx]
        class_id = self.current_class_idx
        duration = class_["duration"]
        students = class_["students"]
        lecturer = class_["lecturer"]

        room_id = action // self.total_slots
        slot = action % self.total_slots

        reward = 0.0
        valid = True

        room_capacity = self.rooms[room_id]["capacity"]
        
        # --- Hard constraint checks ---
        if len(students) > room_capacity:  # Check room capacity
            reward = -1.0
            valid = False
        elif slot + duration > self.total_slots: # Check if slot is valid
            reward = -1.0
            valid = False
        elif np.any(self.room_slot_occupancy[room_id][slot:slot + duration]): # Check if room is already occupied 
            reward = -1.0
            valid = False
        elif any((slot + i) in self.student_schedule[s] for i in range(duration) for s in students): # Check if students are already scheduled
            reward = -1.0
            valid = False
        elif any((slot + i) in self.lecturer_schedule[lecturer] for i in range(duration)): # Check if lecturer is already scheduled
            reward = -1.0
            valid = False

        if valid:
            # Update hard constraints
            for i in range(duration):
                self.room_slot_occupancy[room_id][slot + i] = True
                for s in students:
                    self.student_schedule[s].add(slot + i)
                self.lecturer_schedule[lecturer].add(slot + i)

            self.schedule[class_id] = (room_id, slot)
            reward = 1.0  # base reward for valid schedule

            # --- Soft constraint: avoid early morning slots (8:00 AM) ---
            if slot % self.slots_per_day == 0:
                reward -= 0.1  

            # --- Soft constraint: penalize student gaps > 2 hours (i.e. 3+ empty slots) ---
            day = slot // self.slots_per_day
            for s in students:
                for i in range(duration):
                    self.student_day_slots[s][day].append(slot + i)

            gap_penalty = 0.0
            for s in students:
                for day_slots in self.student_day_slots[s].values():
                    if len(day_slots) < 2:
                        continue
                    sorted_slots = sorted(day_slots)
                    for i in range(len(sorted_slots) - 1):
                        gap = sorted_slots[i + 1] - sorted_slots[i] - 1
                        if gap >= 3:
                            gap_penalty -= 0.1 

            reward += gap_penalty

            # # --- Soft constraint: penalize lecturer back-to-back classes ---
            # lecturer_slots = list(self.lecturer_schedule[lecturer])
            # lecturer_slots.sort()

            # lecturer_penalty = 0.0
            # for i in range(len(lecturer_slots) - 1):
            #     if lecturer_slots[i + 1] - lecturer_slots[i] == 1:
            #         lecturer_penalty -= 0.1  # Penalty for no break

            # reward += lecturer_penalty

        self.current_class_idx += 1
        done = self.current_class_idx >= self.num_classes
        # if done:
        #     reward += 2.0  # bonus for completing the entire schedule


        return self._get_observation(), reward, done, False, {}


    def render(self):
        print("Current Schedule:")
        for idx, entry in enumerate(self.schedule):
            if entry is not None:
                room_idx, slot = entry
                room_id = self.rooms[room_idx]["id"]
                print(f"Class {idx + 1} - Room ID {room_id}, Slot {slot}")
            else:
                print(f"Class {idx + 1} - Not Scheduled")

