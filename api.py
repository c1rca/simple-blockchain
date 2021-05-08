from flask import Flask, request, jsonify
from flask_cors import CORS
import yaml
from Blockchain import Blockchain
import json
from flask_swagger import swagger

app = Flask(__name__)
CORS(app)

config = {
    "ip": "0.0.0.0",
    "port": "8885",
    "swagger_yaml": "swagger.yaml",
    "debug": True
}

b = Blockchain()
b.genesis()


@app.route('/newblock', methods=['POST'])
def new_block():
    args = request.get_json()
    msg = args['msg']
    new_block = b.new_block(msg=msg)
    print(new_block)
    return new_block

@app.route('/chain', methods=['GET'])
def get_chain():
    chain = b.get_chain()
    cjson = json.dumps(chain, indent=4)
    return cjson

@app.route('/chain/validate', methods=['GET'])
def validate_chain():
    return jsonify(isValid=str(b.validate_chain()))

@app.route("/spec")
def spec():
    f = open(config['swagger_yaml'], "r")
    return yaml.load(f.read(), Loader=None)


if __name__ == '__main__':
    app.run(host=config['ip'],
            port=config['port'],
            debug=config['debug'])

