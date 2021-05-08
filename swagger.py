from flask import Flask
from flask_swagger_ui import get_swaggerui_blueprint

app = Flask(__name__)

config = {
    "ip": "0.0.0.0",
    "port": "5558",
    "debug": True
}

SWAGGER_URL = '/docs'
API_URL = 'http://alexblockchainproject.com:8885/spec'

swaggerui_blueprint = get_swaggerui_blueprint(
    SWAGGER_URL,
    API_URL,
    config={
        'app_name': "Simple Blockchain API"
    }
)

app.register_blueprint(swaggerui_blueprint)

app.run(host=config['ip'], port=config['port'], debug=config['debug'])
