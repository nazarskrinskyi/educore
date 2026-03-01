#!/bin/bash

# Script to start ngrok and automatically configure Telegram webhook
# This runs ngrok in the background and sets up the webhook

set -e

# Check if ngrok is already running
if curl -s http://localhost:4040/api/tunnels > /dev/null 2>&1; then
    echo "Ngrok is already running!"
    read -p "Do you want to restart it? (y/n) " -n 1 -r
    echo
    if [[ $REPLY =~ ^[Yy]$ ]]; then
        echo "Stopping existing ngrok..."
        pkill ngrok || true
        sleep 2
    else
        echo "Using existing ngrok instance..."
        bash scripts/setup-telegram-webhook.sh
        exit 0
    fi
fi

# Get the IP address from .env comment or use default
IP_ADDRESS="172.22.134.110"
if [ -f .env ]; then
    ENV_IP=$(grep -o 'ngrok http [0-9.]*:' .env | grep -o '[0-9.]*' | head -n 1)
    if [ ! -z "$ENV_IP" ]; then
        IP_ADDRESS="$ENV_IP"
    fi
fi

echo "Starting ngrok on ${IP_ADDRESS}:80..."

# Start ngrok in the background
nohup ngrok http ${IP_ADDRESS}:80 > /dev/null 2>&1 &

# Wait for ngrok to be ready
echo "Waiting for ngrok to initialize..."
for i in {1..10}; do
    if curl -s http://localhost:4040/api/tunnels > /dev/null 2>&1; then
        echo "Ngrok is ready!"
        break
    fi
    if [ $i -eq 10 ]; then
        echo "Error: Ngrok failed to start"
        exit 1
    fi
    sleep 1
done

# Set up the webhook
bash scripts/setup-telegram-webhook.sh

echo ""
echo "✓ Setup complete!"
echo "Ngrok is running in the background. To stop it, run: pkill ngrok"
