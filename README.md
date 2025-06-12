# Raspberry pi Soundboard

A web-based soundboard that plays audio through your Raspberry Pi's speakers. 

## Features
- **Web-controlled** plays through Pi speakers
- **User accounts** login system
- **Upload** MP3/WAV files
- **Clickable Buttons** play the sounds instantly

## Technology used
- Raspberry Pi with speakers
- PHP, HTML, CSS
- Python 3 (Flask, Pygame)
- SQLite3 databases

## File Structure

```
html/
├── app.py                 # Sound server (Flask)
├── login.php              # Login page
├── sounds.php             # Soundboard UI
├── upload.php             # File uploader
├── Uploads/               # Folder for sounds
| ├── Sound1.wav           # wav files
| └── Sound2.mp3           # or mp3 files
├── styles/
│   ├── style.css          # Main styles
│   └── navBar.css
sql/
│ ├── users.db             # User logins
│ └── sounds.db            # Sound paths and who owns it
```
