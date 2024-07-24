from flask import Flask, request, render_template_string
import os

app = Flask(__name__)

@app.route('/')
def home():
    return '''
        <h1>Welcome to the vulnerable Flask app!</h1>
        <form action="/view" method="get">
            <label for="filename">Enter filename:</label>
            <input type="text" id="filename" name="filename">
            <input type="submit" value="View File">
        </form>
    '''

@app.route('/view')
def view_file():
    filename = request.args.get('filename')
    
    # Vulnerable code: directly using user input to read files
    try:
        with open(os.path.join('files', filename), 'r') as f:
            file_content = f.read()
    except FileNotFoundError:
        return f"<h1>File not found: {filename}</h1>"
    except Exception as e:
        return f"<h1>Error: {str(e)}</h1>"

    return render_template_string("<pre>{{ content }}</pre>", content=file_content)

if __name__ == '__main__':
    app.run(debug=True)
