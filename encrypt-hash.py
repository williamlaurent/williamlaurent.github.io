import hashlib
import base64

def md5_encrypt(text):
    md5_hash = hashlib.md5()
    md5_hash.update(text.encode('utf-8'))
    return md5_hash.hexdigest()

def sha1_encrypt(text):
    sha1_hash = hashlib.sha1()
    sha1_hash.update(text.encode('utf-8'))
    return sha1_hash.hexdigest()

def base64_encrypt(text):
    encoded_bytes = base64.b64encode(text.encode('utf-8'))
    return encoded_bytes.decode('utf-8')

# def base64_decrypt(text):
#    decoded_bytes = base64.b64decode(text.encode('utf-8'))
#    return decoded_bytes.decode('utf-8')

while True:
    print("Pilih operasi:")
    print("1. Encrypt MD5")
    print("2. Encrypt SHA-1")
    print("3. Encrypt Base64")
#    print("4. Decrypt Base64")
    print("4. Keluar")

    choice = input("Masukkan pilihan (1/2/3/4): ")

    if choice == '1':
        text = input("Masukkan teks yang ingin di-MD5-kan: ")
        result = md5_encrypt(text)
        print("Hasil MD5: " + result)
    elif choice == '2':
        text = input("Masukkan teks yang ingin di-SHA-1-kan: ")
        result = sha1_encrypt(text)
        print("Hasil SHA-1: " + result)
    elif choice == '3':
        text = input("Masukkan teks yang ingin di-Base64-kan: ")
        result = base64_encrypt(text)
        print("Hasil Base64: " + result)
    #elif choice == '4':
    #    text = input("Masukkan teks Base64 yang ingin di-decode: ")
    #    try:
    #        result = base64_decrypt(text)
    #        print("Hasil Decode Base64: " + result)
    #    except Exception as e:
    #        print("Gagal mendecode Base64: " + str(e))
    elif choice == '4':
        break
    else:
        print("Pilihan tidak valid. Silakan pilih lagi.")
