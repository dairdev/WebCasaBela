#!/bin/bash

# Step 1: Login and save the token
echo "Logging in..."
# Step 1: Login and get the token
echo "🔐 Logging in..."
LOGIN_RESPONSE=$(curl -s -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email": "dennis.dair@gmail.com", "password": "1a2b3c4d"}')

echo "$LOGIN_RESPONSE"
TOKEN=$(echo "$LOGIN_RESPONSE" | jq -r '.token')

if [ -z "$TOKEN" ]; then
  echo "❌ Login failed. Invalid credentials or server error."
  exit 1
fi
echo "✅ Login successful. Token: $TOKEN"

# Step 2: Use the token to make authenticated requests
echo "Fetching user details..."
response=$(curl -s -o /dev/null -w "%{http_code}" -X GET http://localhost:8000/api/auth/me \
  -H "Authorization: Bearer $TOKEN")

if [ "$response" -eq 200 ]; then
  echo "✅ Success: User details retrieved (HTTP $response)"
else
  echo "❌ Failure: User details retrieval failed (HTTP $response)"
  exit 1
fi
