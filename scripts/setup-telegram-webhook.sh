#!/bin/bash

# Script to automatically set up Telegram webhook with ngrok URL
# This script waits for ngrok to start and then updates the Telegram webhook

set -e

# Load environment variables
if [ -f .env ]; then
    export $(cat .env | grep -v '^#' | grep TELEGRAM_BOT_TOKEN | xargs)
fi

if [ -z "$TELEGRAM_BOT_TOKEN" ]; then
    echo "Error: TELEGRAM_BOT_TOKEN not found in .env file"
    exit 1
fi

echo "Waiting for ngrok to start..."
sleep 3

# Get ngrok URL from API
NGROK_URL=$(curl -s http://localhost:4040/api/tunnels | grep -o '"public_url":"https://[^"]*' | grep -o 'https://[^"]*' | head -n 1)

if [ -z "$NGROK_URL" ]; then
    echo "Error: Could not get ngrok URL. Make sure ngrok is running."
    exit 1
fi

echo "Ngrok URL detected: $NGROK_URL"

# Set Telegram webhook
WEBHOOK_URL="${NGROK_URL}/api/telegram/webhook"
TELEGRAM_API="https://api.telegram.org/bot${TELEGRAM_BOT_TOKEN}/setWebhook?url=${WEBHOOK_URL}"

echo "Setting Telegram webhook to: $WEBHOOK_URL"
RESPONSE=$(curl -s -X POST "$TELEGRAM_API")

if echo "$RESPONSE" | grep -q '"ok":true'; then
    echo "✓ Telegram webhook successfully set!"
    echo "Response: $RESPONSE"
else
    echo "✗ Failed to set Telegram webhook"
    echo "Response: $RESPONSE"
    exit 1
fi

# Display webhook info
echo ""
echo "Getting webhook info..."
curl -s "https://api.telegram.org/bot${TELEGRAM_BOT_TOKEN}/getWebhookInfo" | python3 -m json.tool || echo "$RESPONSE"
