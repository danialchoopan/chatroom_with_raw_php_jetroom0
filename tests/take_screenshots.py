from playwright.sync_api import sync_playwright
import time
import os

def take_screenshots():
    with sync_playwright() as p:
        browser = p.chromium.launch(headless=True)
        page = browser.new_page(viewport={'width': 1280, 'height': 720})

        # 1. Login Page
        page.goto("http://localhost:8000/login")
        page.screenshot(path="screenshots/login.png")

        # 2. Perform Login
        page.fill('input[name="username"]', "ali")
        page.fill('input[name="password"]', "password")
        page.click('button[type="submit"]')
        page.wait_for_url("**/chat*")
        time.sleep(2) # Wait for messages to load

        # 3. Main Chatroom
        page.screenshot(path="screenshots/chatroom_main.png")

        # 4. Private Chat
        # Find Reza's ID (should be 2 based on seed)
        page.goto("http://localhost:8000/private?user_id=2")
        time.sleep(2)
        page.screenshot(path="screenshots/private_chat.png")

        browser.close()

if __name__ == "__main__":
    take_screenshots()
