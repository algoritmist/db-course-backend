import requests
import json

from base import *

url = base_url + '/authorize.php'

headers = {
    'content-type': 'application/json'
}

body = {
    "id" : 0,
    "first_name" : "A",
    "last_name" : "B",
}

r = requests.post(url, data = json.dumps(body), headers = headers, verify=False)
print(r.text)