import os
import json
import numpy as np
from stable_baselines3 import PPO
from stable_baselines3.common.vec_env import DummyVecEnv
from stable_baselines3.common.monitor import Monitor
from stable_baselines3.common.callbacks import EvalCallback
from rl_env import SchedulingEnv

# === Setup Paths ===
model_dir = "scheduler/rl_model"
log_dir = "scheduler/logs"
os.makedirs(model_dir, exist_ok=True)
os.makedirs(log_dir, exist_ok=True)

# === Create Environment ===
def make_env():
    env = SchedulingEnv()
    env = Monitor(env)  # logs reward, episode length, etc.
    return env

env = DummyVecEnv([make_env])  # wrap in vectorized env for SB3 compatibility

# === PPO Model ===
model = PPO(
    "MlpPolicy",
    env,
    verbose=1,
    tensorboard_log=log_dir,
)

# === Optional: Eval Callback to track progress ===
eval_env = DummyVecEnv([make_env])
eval_callback = EvalCallback(
    eval_env,
    best_model_save_path=model_dir,
    log_path=log_dir,
    eval_freq=500,
    deterministic=True,
    render=False,
)

# === Train Model ===
print("🚀 Starting training...")
model.learn(
    total_timesteps=50_000,  # increase this as needed
    callback=eval_callback
)

# === Save Final Model ===
model.save(os.path.join(model_dir, "final_model"))
print(f"✅ Model saved to: {model_dir}/final_model")
