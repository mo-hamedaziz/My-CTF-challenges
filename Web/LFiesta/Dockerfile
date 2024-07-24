# Use an official Python runtime as a parent image
FROM python:3.9-slim

# Create a user with UID 1000
RUN useradd -u 1000 user

# Set the working directory in the container
WORKDIR /app

# Copy the current directory contents into the container at /app
COPY . /app/

# Install any needed packages specified in requirements.txt
RUN pip install --no-cache-dir -r requirements.txt

# Remove the requirements file after installation
RUN rm /app/requirements.txt

# Copy the flag.txt file and rename it with a random suffix
RUN mv /app/flag.txt /flag-`tr -dc A-Za-z0-9 < /dev/urandom | head -c 20`.txt

# Set permissions for the application directory
RUN chown -R user:user /app

# Set the environment variable for Flask
ENV FLASK_APP=app.py

# Run the Flask app
USER user
CMD ["flask", "run", "--host=0.0.0.0"]
