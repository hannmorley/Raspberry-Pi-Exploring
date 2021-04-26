#!/usr/bin/python
import pyttsx3
import speech_recognition as sr
import pyaudio
import os
from gpiozero import LED

for i, mic_name in enumerate (sr.Microphone.list_microphone_names()):
    print("mic: " + mic_name)
    if "USB PnP Sound Device" in mic_name:
        print("USB Audio Device " + mic_name)
        mic = sr.Microphone(device_index=i, chunk_size=1024, sample_rate=48000)


pi_ear = sr.Recognizer()
pi_mouth = pyttsx3.init()
light_1 = LED(17)
fan = LED(27)
light_1.on()
fan.on()

while True:
    need_speak = False
    with mic as source:
        # pi_ear.pause_thpi_eareshold=1
        pi_ear.adjust_for_ambient_noise(source, duration=0.5)
        print("\033[0;35mpi: \033[0m I'm listening")
        audio = pi_ear.listen(source)
    try:
        you = pi_ear.recognize_google(audio)
    except:
        you = ""
    msg = you
    if you == "":
        msg="I can't hear you, please try again"
        need_speak = True
    elif "turn on light" in you:
        # msg="sure, I'm turning on the light"
        light_1.on()
        light_1.off()
        os.system("sudo pico2wave -w turnonlight.wav -l en-GB 'Mistress, I have turned the light on.  I hope it is to your satisfaction.' && sox turnonlight.wav turnonlight2.wav pitch -200 vol 1.5 && play turnonlight2.wav")
        # need_speak = True
    elif "turn on fan" in you:
        # msg="sure, I'm turning on the fan"
        fan.on()
        fan.off()
        os.system("sudo pico2wave -w turnonfan.wav -l en-GB 'Mistress, I have turned the fan on.  I hope it is to your satisfaction.' && sox turnonfan.wav turnonfan2.wav pitch -200 vol 1.5 && play turnonfan2.wav")
        # need_speak = True
    elif "turn on the light" in you:
        # msg = "sure, I'm turning on the light"
        light_1.on()
        light_1.off()
        os.system("sudo pico2wave -w turnonlite.wav -l en-GB 'Mistress, I have turned the light on.  I hope it is to your satisfaction.' && sox turnonlite.wav turnonlite2.wav pitch -200 vol 1.5 && play turnonlite2.wav")
        # need_speak = True
    elif "turn off light" in you:
        # msg = "sure, I'm turning off the light"
        light_1.on()
        os.system("sudo pico2wave -w turnofflight.wav -l en-GB 'Mistress, I have turned the light off.  I hope it is to your satisfaction.' && sox turnofflight.wav turnofflight2.wav pitch -200 vol 1.5 && play turnofflight2.wav")
                # need_speak = True
    elif "turn off fan" in you:
        # msg = "sure, I'm turning off the fan"
        fan.on()
        os.system("sudo pico2wave -w turnofffan.wav -l en-GB 'Mistress, I have turned the fan off.  I hope it is to your satisfaction.' && sox turnofffan.wav turnofffan2.wav pitch -200 vol 1.5 && play turnofffan2.wav")
        # need_speak = True
    elif "turn off the light" in you:
        # msg="sure, I'm turning off the light"
        light_1.on()
        os.system("sudo pico2wave -w turnofflite.wav -l en-GB 'Mistress, I have turned the light off.  I hope it is to your satisfaction.' && sox turnofflite.wav turnofflite2.wav pitch -200 vol 1.5 && play turnofflite2.wav")
        # need_speak = True
    elif "bye" in you:
        os.system("sudo pico2wave -w tallyho.wav -l en-GB 'Thank you, Mistress and cheersss.' && sox tallyho.wav tallyho2.wav pitch -200 vol 1.5 && play tallyho2.wav")
        # msg="the end"
        print("\033[0;32myou:\033[0m " + you)
        print("\033[0;35mpi:\033[0m " + msg)
        # pi_mouth.say(msg)
        pi_mouth.runAndWait()
        break
    print("\033[0;32myou:\033[0m " + you)
    print("\033[0;35mpi:\033[0m " + msg)
    if need_speak == True:
        # pi_mouth.say(msg)
        pi_mouth.runAndWait()
        
