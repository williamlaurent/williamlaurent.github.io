import random
import string

# Userpass generator by Willmet

def generate_username(length):
    characters = string.ascii_letters + string.digits
    username = ''.join(random.choice(characters) for _ in range(length))
    return username

def generate_password(length):
    characters = string.ascii_letters + string.digits + string.punctuation
    password = ''.join(random.choice(characters) for _ in range(length))
    return password

if __name__ == "__main__":
    num_usernames = int(input("Masukkan jumlah username yang ingin Anda buat: "))
    username_length = 6  # Ganti dengan panjang username yang Anda inginkan
    password_length = 8  # Ganti dengan panjang password yang Anda inginkan

    for i in range(num_usernames):
        username = generate_username(username_length)
        password = generate_password(password_length)

        print(f"Username {i + 1}:", username)
        print(f"Password {i + 1}:", password)
        print()
