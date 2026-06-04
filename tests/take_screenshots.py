import os
import time
import subprocess
from playwright.sync_api import sync_playwright

def take_screenshots():
    # Start the server
    server = subprocess.Popen(['php', '-S', 'localhost:8000', '-t', 'public'])
    time.sleep(2)  # Wait for server to start

    try:
        with sync_playwright() as p:
            browser = p.chromium.launch(headless=True)

            # 1. Login Page
            page = browser.new_page()
            page.goto('http://localhost:8000/login')
            page.wait_for_load_state('networkidle')
            page.screenshot(path='screenshots/login.png', full_page=False)
            print("Captured login.png")

            # Perform login as admin
            page.fill('input[name="username"]', 'admin')
            page.fill('input[name="password"]', 'admin123')
            page.click('button[type="submit"]')
            page.wait_for_load_state('networkidle')

            # 2. Main Chatroom
            page.goto('http://localhost:8000/chat')
            page.wait_for_selector('#messages')
            time.sleep(1) # Wait for JS to render
            page.screenshot(path='screenshots/chatroom_main.png')
            print("Captured chatroom_main.png")

            # 3. Private Chat
            # Find a user to chat with (e.g., ali)
            page.click('text=ali')
            page.wait_for_selector('#messages')
            time.sleep(1)
            page.screenshot(path='screenshots/private_chat.png')
            print("Captured private_chat.png")

            # 4. Admin Dashboard
            page.goto('http://localhost:8000/admin')
            page.wait_for_selector('table')
            page.screenshot(path='screenshots/admin_panel.png')
            print("Captured admin_panel.png")

            browser.close()
    finally:
        server.terminate()

if __name__ == "__main__":
    if not os.path.exists('screenshots'):
        os.makedirs('screenshots')
    take_screenshots()
