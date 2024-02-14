import requests

def call_api():
    url = 'http://localhost:8080/api/lote/create'
    response = requests.get(url)
    
    if response.status_code == 200:
        print("Respuesta de la API:", response.text)
    else:
        print("Error al llamar a la API:", response.status_code)

if __name__ == "__main__":
    call_api()
