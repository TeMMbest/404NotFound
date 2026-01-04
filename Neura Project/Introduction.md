# AI TTS Bot - Neura-chan Edition 🎤✨

A simple AI-powered text-to-speech bot that uses OpenAI's LLM and responds to your voice with a cute voice like Neura-chan!

## Features

- 🎤 **Voice Input**: Speak to the bot using your microphone
- 🤖 **AI Responses**: Powered by OpenAI's GPT models
- 🗣️ **Cute Voice**: Text-to-speech with adorable voice settings
- 💬 **Conversational**: Maintains context throughout the conversation
- 🎯 **Simple**: Easy to use and customize

## Prerequisites

- Python 3.7 or higher
- OpenAI API key ([Get one here](https://platform.openai.com/api-keys))
- Microphone connected to your computer
- Windows (for best TTS voice support)

## Installation

1. **Install Python dependencies:**

   ```bash
   pip install -r requirements.txt
   ```

2. **Note on PyAudio:**
   If you encounter issues installing PyAudio on Windows, you may need to install it manually:

   ```bash
   pip install pipwin
   pipwin install pyaudio
   ```

   Or download the appropriate wheel file from [here](https://www.lfd.uci.edu/~gohlke/pythonlibs/#pyaudio) and install it.

3. **Set your OpenAI API key:**

   **Windows (PowerShell):**

   ```powershell
   $env:OPENAI_API_KEY="your-api-key-here"
   ```

   **Windows (Command Prompt):**

   ```cmd
   set OPENAI_API_KEY=your-api-key-here
   ```

   **Linux/Mac:**

   ```bash
   export OPENAI_API_KEY="your-api-key-here"
   ```

   Or you can enter it when prompted when running the bot.

## Usage

1. **Run the bot:**

   ```bash
   python ai_tts_bot.py
   ```

2. **Speak to the bot:**

   - Wait for the "🎤 Listening..." message
   - Speak your question or message
   - The bot will process your speech and respond with voice

3. **Exit the bot:**
   - Say "quit", "exit", "stop", or "bye"
   - Or press `Ctrl+C`

## Customization

### Change the AI Model

Edit `ai_tts_bot.py` and change the model in the `get_ai_response` method:

```python
model="gpt-4"  # Instead of gpt-3.5-turbo
```

### Adjust Voice Settings

Modify the `_setup_cute_voice` method to change:

- **Rate**: Speech speed (default: 180, higher = faster)
- **Volume**: Volume level (0.0 to 1.0)
- **Pitch**: Voice pitch (if supported by your TTS engine)

### Change the AI Personality

Edit the system message in the `__init__` method:

```python
{"role": "system", "content": "Your custom personality prompt here"}
```

## Troubleshooting

### Microphone not working

- Check that your microphone is connected and enabled
- Make sure other applications aren't using the microphone
- Try adjusting the microphone volume in Windows settings

### Speech recognition issues

- Speak clearly and at a moderate pace
- Reduce background noise
- Check your internet connection (uses Google Speech Recognition)

### TTS voice doesn't sound right

- On Windows, you can change the default voice in Settings > Time & Language > Speech
- Try different voices available on your system
- Adjust the rate and pitch settings in the code

### API Key errors

- Make sure your OpenAI API key is valid
- Check that you have credits in your OpenAI account
- Verify the API key is set correctly in your environment

## Notes

- The bot uses Google Speech Recognition which requires an internet connection
- OpenAI API usage will incur costs based on your usage
- The conversation history is limited to the last 10 exchanges to manage token usage
- For best results, use in a quiet environment

## License

Free to use and modify for personal projects!
