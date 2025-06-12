# Raspberry pi Soundboard

A web-based soundboard that plays audio through your Raspberry Pi's speakers. 

## Features
- **Web-controlled** plays through Pi speakers
- **User accounts** login system
- **Upload** MP3/WAV files
- **Clickable Buttons** sound buttons

## Technology used
- Raspberry Pi with speakers
- PHP, HTML, CSS
- Python 3 (Flask, Pygame)
- SQLite3 databases

## File Structure

soundboard/
├── app.py                 # Sound server (Flask)
├── login.php              # Login page
├── sounds.php             # Soundboard UI
├── upload.php             # File uploader
├── styles/
│   ├── style.css          # Main styles
│   └── navBar.css
