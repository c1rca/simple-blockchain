# Simple Blockchain Documentation

## Requirements

- Flask
- Flask cors
- Flask swagger
- Flask Swagger UI

## Installing requirements

### Ubuntu 20.04

`pip3 install -r requirements.txt`

## API

Swagger documentation: http://alexblockchainproject.com:5558/docs/

## [POST]  /newblock

Add new block to blockchain.

#### JSON Payload:
```json
{
   "index":1,
   "message":"example",
   "prev_hash":"d6926660be9c6253998e4d6dc2793a1d930fec05412e40340abcc1f25304a4db",
   "timestamp":"1620486451.6928692"
}
```

#### cURL Example:

```bash
curl -X POST "http://alexblockchainproject.com:8885/newblock" -H  "accept: application/json" -H  "Content-Type: application/json" -d "{\"msg\":\"Example\"}"
```

## [GET]  /chain

Returns the blockchain data.

#### cURL Example:

```bash
curl -X GET "http://alexblockchainproject.com:8885/chain" -H  "accept: application/json"
```

## [GET]  /chain/validate

Returns True if blockchain hashes are valid, False if a hash is invalid.

#### cURL Example:

```bash
curl -X GET "http://alexblockchainproject.com:8885/chain/validate" -H  "accept: application/json"
```



