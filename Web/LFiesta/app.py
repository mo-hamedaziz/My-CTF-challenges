from flask import Flask, request, send_from_directory, abort
import os

app = Flask(__name__)

# Directory where files are stored
FILE_DIRECTORY = './files'

@app.route('/')
def index():
    # HTML for displaying links
    links = [
        'file1.txt',
        'file2.txt',
        'file3.txt'
    ]
    
    html = "<p>Welcome to my journal app!</p>"
    for link in links:
        html += f'<p><a href="/{link}">{link}</a></p>'
    
    return html

@app.route('/<path:filename>')
def serve_file(filename):
    # Prevent directory traversal
    if '..' in filename or filename.startswith('/'):
        abort(404, description="Invalid file!")

    file_path = os.path.join(FILE_DIRECTORY, filename)

    if os.path.isfile(file_path):
        return send_from_directory(FILE_DIRECTORY, filename)
    else:
        return "File not found!", 404

if __name__ == '__main__':
    app.run(debug=True, host='0.0.0.0')