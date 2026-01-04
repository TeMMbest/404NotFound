import os
import speech_recognition as sr
import pyttsx3
import threading
import queue
import json
import time

try:
    from openai import OpenAI
except ImportError as e:
    try:
        print("❌ Error: OpenAI package not found. Please install it using:")
    except UnicodeEncodeError:
        print("ERROR: OpenAI package not found. Please install it using:")
    print("   pip install openai>=1.0.0")
    print("\nOr install all requirements:")
    print("   pip install -r requirements.txt")
    raise


def _safe_print(text):
    """Print text, handling Unicode encoding errors for emojis"""
    try:
        print(text)
    except UnicodeEncodeError:
     
        import re
       
        text_ascii = re.sub(r'[^\x00-\x7F]+', '', text)
        print(text_ascii if text_ascii.strip() else text.encode('ascii', 'ignore').decode('ascii'))


def _write_log(location, message, data):
    """Write a debug log entry"""
    log_path = r"c:\Users\Admin\Downloads\AI project programs\.cursor\debug.log"
    try:
        log_dir = os.path.dirname(log_path)
        if log_dir and not os.path.exists(log_dir):
            os.makedirs(log_dir, exist_ok=True)
        with open(log_path, "a", encoding="utf-8") as f:
            f.write(json.dumps({"location": location, "message": message, "data": data, "timestamp": int(time.time() * 1000)}) + "\n")
    except Exception:
        pass


# It starts here the Neura-verse
class NeuraTTS:
    def __init__(self, api_key=None):
        """
        Initialize Neura-chan, the cute AI TTS assistant
        

# It starts here the Neura-verse      
        Args:
            api_key: OpenAI API key. If None, will try to get from environment variable OPENAI_API_KEY
        """
        _write_log("ai_tts_bot.py:__init__", "Initialization started", {"api_key_provided": api_key is not None})
        if api_key is None:
            api_key = os.getenv('OPENAI_API_KEY')
            if not api_key:
                _write_log("ai_tts_bot.py:__init__", "API key not found", {"error": "API key missing"})
                raise ValueError("OpenAI API key not found. Please set OPENAI_API_KEY environment variable or pass it as parameter.")
        
        try:
            self.client = OpenAI(api_key=api_key)
            _write_log("ai_tts_bot.py:__init__", "OpenAI client created", {"success": True})
        except Exception as e:
            _write_log("ai_tts_bot.py:__init__", "OpenAI client creation failed", {"error": str(e), "error_type": type(e).__name__})
            raise
        try:
            self.recognizer = sr.Recognizer()
            self.microphone = sr.Microphone()
            _write_log("ai_tts_bot.py:__init__", "Speech recognition initialized", {"success": True})
        except Exception as e:
            _write_log("ai_tts_bot.py:__init__", "Speech recognition init failed", {"error": str(e), "error_type": type(e).__name__})
            raise
        try:
            self.tts_engine = pyttsx3.init()
            self._setup_cute_voice()
            _write_log("ai_tts_bot.py:__init__", "TTS engine initialized", {"success": True})
        except Exception as e:
            _write_log("ai_tts_bot.py:__init__", "TTS engine init failed", {"error": str(e), "error_type": type(e).__name__})
            raise


        self.conversation_history = [
            {"role": "system", "content": "You are Neura-chan, a super cute and friendly AI assistant with a bubbly personality! You love making people smile with your cheerful, playful, and adorable responses. Use lots of cute emojis, exclamation points, and speak in a sweet, energetic way like a cute anime character. Always stay in character as Neura-chan and keep your responses concise but full of personality, plus rizz! Your goal is to make the user feel happy and entertained while chatting with you!"}
        ]

        self.tts_queue = queue.Queue()
        self.is_speaking = False
        
        _safe_print("🎤 Neura-chan is waking up! ✨ Adjusting microphone for our chat...")
        try:
            _write_log("ai_tts_bot.py:__init__", "Before microphone adjustment", {})
            with self.microphone as source:
                self.recognizer.adjust_for_ambient_noise(source, duration=1)
            _write_log("ai_tts_bot.py:__init__", "Microphone adjustment complete", {"success": True})
        except Exception as e:
            _write_log("ai_tts_bot.py:__init__", "Microphone adjustment failed", {"error": str(e), "error_type": type(e).__name__})
            raise
        _safe_print("✅ Neura-chan is ready to chat! 💕 Speak to me!")
    
    def _setup_cute_voice(self):
        """Configure TTS engine to sound super cute like Neura-chan!"""
        voices = self.tts_engine.getProperty('voices')

        for voice in voices:

# Voice selection

            if 'female' in voice.name.lower() or 'zira' in voice.name.lower() or 'samantha' in voice.name.lower():
                self.tts_engine.setProperty('voice', voice.id)
                break
        self.tts_engine.setProperty('rate', 180)
        self.tts_engine.setProperty('volume', 1.0)
        try:
            self.tts_engine.setProperty('pitch', 50)
        except Exception:
            pass
    
    def listen(self):
        """Listen to microphone and return transcribed text"""
        try:
            with self.microphone as source:
                _safe_print("\n🎤 Neura-chan is listening intently! 💖 (speak now)")
                audio = self.recognizer.listen(source, timeout=5, phrase_time_limit=10)
            
            _safe_print("🔄 Neura-chan is processing your words... ✨")
            text = self.recognizer.recognize_google(audio)
            _safe_print(f"👤 You said: {text}")
            return text
        except sr.WaitTimeoutError:
            _safe_print("⏱️ Neura-chan didn't hear anything! Try speaking again! 🎯")
            return None
        except sr.UnknownValueError:
            _safe_print("❌ Neura-chan couldn't understand that! Please try again! 💭")
            return None
        except sr.RequestError as e:
            _safe_print(f"❌ Oh no! Neura-chan has a speech recognition problem: {e}")
            return None
        except Exception as e:
            _safe_print(f"❌ Oops! Neura-chan encountered an error: {e}")
            return None
    
    def get_ai_response(self, user_input):
        """Get response from OpenAI"""
        self.conversation_history.append({"role": "user", "content": user_input})
        
        try:
            _safe_print("🤖 Neura-chan is thinking hard! 💭✨")
            response = self.client.chat.completions.create(
                model="gpt-3.5-turbo",
                messages=self.conversation_history,
                max_tokens=150,
                temperature=0.8
            )
            
            ai_message = response.choices[0].message.content
            self.conversation_history.append({"role": "assistant", "content": ai_message})
            if len(self.conversation_history) > 21:
                self.conversation_history = [self.conversation_history[0]] + self.conversation_history[-20:]
            
            return ai_message
        except Exception as e:
            error_msg = str(e)
            error_type = type(e).__name__
            if "401" in error_msg or "AuthenticationError" in error_type or "invalid_api_key" in error_msg.lower():
                return "Oh no! Neura-chan can't access the AI service! Please check your API key, okay? 💔"
            elif "429" in error_msg or "RateLimitError" in error_type or "quota" in error_msg.lower() or "rate_limit" in error_msg.lower():
                return "Neura-chan is being rate limited! Please wait a moment and try again, or check your OpenAI usage! ⏳"
            elif "insufficient_quota" in error_msg.lower() or "plan quota" in error_msg.lower():
                return "Neura-chan's quota is all used up! Please check your OpenAI account billing or upgrade your plan! 💸"
            if len(error_msg) > 100:
                error_msg = error_msg[:100] + "..."
            return f"Sorry, Neura-chan encountered an error: {error_msg} 😢"
    
    def speak(self, text):
        """Speak the given text with Neura-chan's super cute voice!"""
        _safe_print(f"🗣️ Neura-chan: {text}")
        try:
            self.tts_engine.say(text)
            self.tts_engine.runAndWait()
        except Exception as e:
            _safe_print(f"❌ Oh no! Neura-chan's voice isn't working: {e} 😢")
    
    def run(self):
        """Neura-chan's magical conversation loop!"""
        print("\n" + "="*50)
        _safe_print("🌟 Welcome to Neura-chan's Magical Chat Room! ✨")
        print("="*50)
        print("Say 'quit', 'exit', 'bye', or 'goodbye' to end our fun chat!")
        print("="*50 + "\n")
        
        while True:
            try:
                user_input = self.listen()
                
                if user_input is None:
                    continue
                if user_input.lower() in ['quit', 'exit', 'stop', 'bye']:
                    self.speak("Bye bye! Neura-chan had so much fun chatting with you! Come back soon! 💕✨")
                    _safe_print("\n👋 Neura-chan says goodbye! See you later! 💖")
                    break
                try:
                    ai_response = self.get_ai_response(user_input)
                except Exception as e:
                    ai_response = "Oh no! Neura-chan had a little hiccup while thinking! Let's try again! 😊"
                try:
                    self.speak(ai_response)
                except Exception as e:
                    _safe_print(f"Neura-chan couldn't speak that response: {e} 😔")
                
            except KeyboardInterrupt:
                _safe_print("\n\n👋 Neura-chan was interrupted! Bye bye! 💔")
                self.speak("Oh no! Neura-chan was interrupted! Bye bye for now! 💕")
                break
            except Exception as e:
                _write_log("ai_tts_bot.py:run", "Exception in main loop", {"error": str(e), "error_type": type(e).__name__})
                _safe_print(f"❌ Neura-chan encountered an error: {e}")
                try:
                    self.speak("Oops! Neura-chan had a little accident! Let's try again! ✨")
                except Exception as speak_error:
                    _write_log("ai_tts_bot.py:run", "Exception in speak during error handling", {"error": str(speak_error), "error_type": type(speak_error).__name__})
                    _safe_print(f"Neura-chan couldn't even speak her error message: {speak_error} 😢")


def main():
    """Neura-chan's magical entry point!"""
    api_key = os.getenv('OPENAI_API_KEY')

# Prompt for API key if not found
    if not api_key:
        _safe_print("⚠️  Oh no! Neura-chan can't find her OPENAI_API_KEY in environment variables! 💔")
        print("You can set it by running: set OPENAI_API_KEY=your_key_here (Windows)")
        print("Or enter it below so Neura-chan can start chatting!")
        api_key = input("\nEnter your OpenAI API key (or press Enter to exit): ").strip()
        if not api_key:
            print("Neura-chan is sad you didn't want to chat... Goodbye! 😢")
            return
    
    try:
        _write_log("ai_tts_bot.py:main", "Creating bot instance", {})
        bot = NeuraTTS(api_key=api_key)
        _write_log("ai_tts_bot.py:main", "Bot instance created, starting run", {})
        bot.run()
    except Exception as e:
        _write_log("ai_tts_bot.py:main", "Failed to initialize or run bot", {"error": str(e), "error_type": type(e).__name__})
        _safe_print(f"❌ Oh no! Neura-chan couldn't start up properly: {e} 😢")


if __name__ == "__main__":
    main()
