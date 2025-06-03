from flask import Flask, request, jsonify
import pygame
import threading
import os
from flask_cors import CORS
app = Flask(__name__)
CORS(app)

pygame.mixer.init()

def play_sound(file_path):
    print(f"Requested file: {file_path}")
    try:
        if os.path.exists(file_path):
            print("File exists. Attempting to play.")
            pygame.mixer.music.load(file_path)
            pygame.mixer.music.play()
        else:
            print("File not found.")
    except Exception as e:
        print(f"Error: {e}")

@app.route('/play-sound', methods=['POST'])
def handle_sound():
    data = request.get_json()
    rel_path = data.get('path')

    # Build full path on disk
    base_path = '/var/www/html'
    abs_path = os.path.normpath(os.path.join(base_path, rel_path))

    print(f"Full path resolved: {abs_path}")

    threading.Thread(target=play_sound, args=(abs_path,)).start()
    return jsonify({'status': 'playing', 'file': abs_path})

if __name__ == '__main__':
    app.run(host='10.80.59.237', port=5000)
