from flask import Flask, request, render_template, redirect, url_for
import os
import re
import socket
import base64

app = Flask(__name__)
app.secret_key = os.urandom(32)

BOT_PORT = int(os.getenv("BOT_PORT", 8080))
BOT_HOST = os.getenv("BOT_HOST", "love-bot")
SITE_URL = os.getenv("SITE_URL", "http://love-letter/")


@app.route("/", methods=["GET", "POST"])
def index():
    """Index page and create a new love letter"""
    if request.method == "POST":
        recipient = request.form.get("recipient", "")
        message = request.form.get("message", "")

        recipient_encoded = base64.b64encode(recipient.encode()).decode()
        message_encoded = base64.b64encode(message.encode()).decode()

        return redirect(url_for('view_love_letter', recipient=recipient_encoded, message=message_encoded))

    return render_template("index.html")


@app.route("/love-letter", methods=["GET"])
def view_love_letter():
    """View a love letter"""
    return render_template("love_letter.html")


@app.route("/report", methods=["GET", "POST"])
def report():
    """Just a report page for XSS chall"""
    response = None
    if request.method == "POST":
        url = request.form["url"]
        pattern = "^" + SITE_URL
        print(f"{pattern=}", flush=True)
        if not url or not re.match(pattern, url):
            return "Invalid URL", 400

        print(f"[+] Sending {url} to bot", flush=True)

        try:
            client = socket.create_connection((BOT_HOST, BOT_PORT))
            client.sendall(url.encode())

            response = []
            while True:
                data = client.recv(1024)
                if not data:
                    break
                response.append(data.decode())
            client.close()
            return "".join(response)
        except Exception as e:
            print(e, flush=True)
            return "Something is wrong...", 500
    return render_template("report.html", response=response)


if __name__ == "__main__":
    app.run(debug=True, host="0.0.0.0", port=80)
