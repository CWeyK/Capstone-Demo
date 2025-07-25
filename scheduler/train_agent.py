from stable_baselines3 import PPO
from stable_baselines3.common.callbacks import CheckpointCallback, EvalCallback
from stable_baselines3.common.vec_env import DummyVecEnv
from rl_env import SchedulingEnv
import os

def main():
    # === Setup training and evaluation environments ===
    train_env = DummyVecEnv([lambda: SchedulingEnv(dataset_path="scheduler/input_data.json")])
    eval_env = DummyVecEnv([lambda: SchedulingEnv(dataset_path="scheduler/input_data.json")])  # can use a different one if desired

    # === Directories ===
    model_dir = "scheduler/models"
    best_model_dir = os.path.join(model_dir, "best_model")
    os.makedirs(model_dir, exist_ok=True)
    os.makedirs(best_model_dir, exist_ok=True)

    model_path = os.path.join(model_dir, "ppo_scheduler_agent")

    # === PPO Model ===
    model = PPO(
        "MlpPolicy",
        train_env,
        verbose=1,
        tensorboard_log="./scheduler/logs",
        device="cpu"
    )

    # === Save best model based on evaluation performance ===
    eval_callback = EvalCallback(
        eval_env,
        best_model_save_path=best_model_dir,
        log_path="./scheduler/eval_logs",
        eval_freq=10000,  # Evaluate every 10k steps
        deterministic=True,
        render=False
    )

    # (Optional) Save regular checkpoints too
    # checkpoint_callback = CheckpointCallback(
    #     save_freq=25000,
    #     save_path=model_dir,
    #     name_prefix="ppo_checkpoint"
    # )

    # === Start training ===
    model.learn(
        total_timesteps=5000000,
        # callback=[eval_callback, checkpoint_callback]  # you can use both
        callback=eval_callback  # or just the eval callback
    )

    # Save final model manually
    model.save(model_path)
    print(f"✅ Final model saved at: {model_path}")
    print(f"⭐ Best model automatically saved at: {best_model_dir}")

if __name__ == "__main__":
    main()
