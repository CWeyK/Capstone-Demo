import json
import os
from ortools.sat.python import cp_model
from collections import defaultdict

# === File Paths ===
base_dir = os.path.dirname(__file__)
input_path = os.path.join(base_dir, "input_data.json")
output_path = os.path.join(base_dir, "output_schedule.json")

# === Load Input Data ===
with open(input_path) as f:
    data = json.load(f)

rooms = data["rooms"]
classes = data["classes"]
lecturers = set(cls["lecturer"] for cls in classes)

# === Build student-to-class map ===
student_to_classes = defaultdict(list)
for cls in classes:
    for student_id in cls["students"]:
        student_to_classes[student_id].append(cls)

# === Time Slots ===
days = ["Mon", "Tue", "Wed", "Thu", "Fri"]
hours = list(range(8, 18))  # 8:00 to 17:00 (last start time if duration = 1)

# === Model Setup ===
model = cp_model.CpModel()
assignments = {}

# === Create Variables (respect room capacity only) ===
for cls in classes:
    duration = cls.get("duration", 1)
    num_students = len(cls["students"])
    for day in days:
        for hour in range(8, 19 - duration):  # must end by 18:00
            for room in rooms:
                if room["capacity"] >= num_students:
                    key = (cls["id"], day, hour, room["id"])
                    assignments[key] = model.NewBoolVar(
                        f"class_{cls['id']}_on_{day}_{hour}_room_{room['id']}"
                    )

# === Each Class Must Be Scheduled Exactly Once ===
for cls in classes:
    duration = cls.get("duration", 1)
    num_students = len(cls["students"])
    possible_assignments = []
    for day in days:
        for hour in range(8, 19 - duration):
            for room in rooms:
                if room["capacity"] >= num_students:
                    key = (cls["id"], day, hour, room["id"])
                    if key in assignments:
                        possible_assignments.append(assignments[key])
    model.AddExactlyOne(possible_assignments)

# === No Room Conflicts ===
for day in days:
    for hour in hours:
        for room in rooms:
            overlapping = []
            for cls in classes:
                dur = cls["duration"]
                for start in range(8, 19 - dur):
                    if start <= hour < start + dur:
                        key = (cls["id"], day, start, room["id"])
                        if key in assignments:
                            overlapping.append(assignments[key])
            if overlapping:
                model.AddAtMostOne(overlapping)

# === No Lecturer Conflicts ===
for day in days:
    for hour in hours:
        for lecturer in lecturers:
            overlapping = []
            for cls in classes:
                if cls["lecturer"] != lecturer:
                    continue
                dur = cls["duration"]
                for start in range(8, 19 - dur):
                    if start <= hour < start + dur:
                        for room in rooms:
                            key = (cls["id"], day, start, room["id"])
                            if key in assignments:
                                overlapping.append(assignments[key])
            if overlapping:
                model.AddAtMostOne(overlapping)

# === No Student Conflicts ===
for day in days:
    for hour in hours:
        for student_id, student_classes in student_to_classes.items():
            overlapping = []
            for cls in student_classes:
                dur = cls["duration"]
                for start in range(8, 19 - dur):
                    if start <= hour < start + dur:
                        for room in rooms:
                            key = (cls["id"], day, start, room["id"])
                            if key in assignments:
                                overlapping.append(assignments[key])
            if len(overlapping) > 1:
                model.AddAtMostOne(overlapping)

# === Solve ===
solver = cp_model.CpSolver()
status = solver.Solve(model)

# === Output ===
print("Solver status:", solver.StatusName(status))
if status in [cp_model.OPTIMAL, cp_model.FEASIBLE]:
    output = []
    for key, var in assignments.items():
        if solver.Value(var):
            class_id, day, hour, room_id = key
            output.append({
                "class_id": class_id,
                "time_slot": f"{day}_{hour:02}:00",
                "room_id": room_id
            })

    with open(output_path, "w") as f:
        json.dump(output, f, indent=2)

    print(f" Schedule generated with {len(output)} classes.")
else:
    print(" No feasible schedule could be found.")
