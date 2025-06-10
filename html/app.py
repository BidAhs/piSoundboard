from flask import Flask, request, jsonify
import pygame
import threading
import os
from flask_cors import CORS

app = Flask(__name__)
CORS(app)

pygame.mixer.init()

def play_sound(file_path):
    if os.path.exists(file_path):
        print("Playing")
        pygame.mixer.music.load(file_path)
        pygame.mixer.music.play()
    else:
        print("Sound not found")

@app.route('/play-sound', methods=['POST'])
def handle_sound():
    data = request.get_json()
    rel = data.get('path')

    base = '/var/www/html'
    path = os.path.normpath(os.path.join(base, rel))

    threading.Thread(target=play_sound, args=(path,)).start()
    return jsonify({'status': 'playing', 'file': path})

if __name__ == '__main__':
    app.run(host='10.80.60.120', port=5000)
