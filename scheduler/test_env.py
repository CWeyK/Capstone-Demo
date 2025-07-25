# test_env.py
from rl_env import SchedulingEnv

# Initialize with your dataset
env = SchedulingEnv('scheduler/input_data.json')  # adjust path

obs = env.reset()
print("Initial observation:", obs)

done = False
step_count = 0

while not done and step_count < 20:  # limit to 20 steps for testing
    action = env.action_space.sample()  # take random action
    obs, reward, done, info = env.step(action)
    print(f"[Step {step_count}] Action: {action}, Reward: {reward}, Done: {done}")
    step_count += 1

print("Episode finished.")
