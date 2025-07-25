from stable_baselines3 import PPO
from rl_env import SchedulingEnv
import os
import json

def convert_schedule(schedule, slots_per_day=10):
    day_names = ["Mon", "Tue", "Wed", "Thu", "Fri"]
    slot_start_hour = 8  # assuming first slot starts at 08:00

    formatted = []
    for class_id, assignment in enumerate(schedule):
        if assignment is None:
            continue  # skip unscheduled classes
        room_id, slot = assignment
        day = int(slot) // slots_per_day
        hour = int(slot) % slots_per_day
        time_str = f"{day_names[day]}_{slot_start_hour + hour:02d}:00"
        formatted.append({
            "class_id": int(class_id + 1),
            "time_slot": time_str,
            "room_id": int(room_id + 1)
        })

    return formatted


def main():
    # model_path = "scheduler/models/ppo_scheduler_agent.zip"
    model_path = os.path.join(os.path.dirname(__file__), "models", "best_model", "best_model.zip")
    # model_path = "scheduler/models/ppo_checkpoint_4525000_steps.zip"
    assert os.path.exists(model_path), "Trained model not found"

    env = SchedulingEnv(dataset_path=os.path.join(os.path.dirname(__file__), "input_data.json"))
    obs, _ = env.reset()
    done = False
    step = 0

    while not done:
        action, _ = model.predict(obs, deterministic=True)
        obs, reward, terminated, truncated, info = env.step(action)
        done = terminated or truncated
        print(f"[Step {step}] Action: {action}, Reward: {reward}, Done: {done}")
        step += 1

    print("\nFinal Schedule:")
    env.render()

    #Save schedule to JSON
    final_schedule = convert_schedule(env.schedule)
    output_path = os.path.join(os.path.dirname(__file__), "rl_output_schedule.json")
    with open(output_path, "w") as f:
        json.dump(final_schedule, f, indent=2)
    print("\nSchedule saved to scheduler/rl_output_schedule.json")

if __name__ == "__main__":
    model_path = os.path.join(os.path.dirname(__file__), "models", "best_model", "best_model")
    model = PPO.load(model_path)
    main()
