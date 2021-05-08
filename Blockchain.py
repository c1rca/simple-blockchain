import json
import time
from hashlib import sha256

class Blockchain:

    def __init__(self, chain=None):
        self.chain = chain or []

    def genesis(self):
        # Create the genesis block
        genesis = {
            "index": 0,
            "message": "Genesis block.",
            "prev_hash": "0",
            "timestamp": str(time.time())
        }
        self.chain.append(genesis)
        self.cache()
        return "Genesis block created."


    def get_chain(self):
        # Return the sorted chain
        chain = self.chain
        chain.sort(key = lambda x: x['index'])
        return chain

    def new_block(self, msg):
        # Create a new block
        index = len(self.chain)
        prev_hash = self.hash(self.chain[-1])
        block = {
            "index": index,
            "message": str(msg),
            "prev_hash": prev_hash,
            "timestamp": str(time.time())
        }
        self.chain.append(block)
        self.cache()
        return block

    def rogue_block(self, msg):
        # Insert a rogue block
        index = 1
        prev_hash = "95efeafa9c6788a3925b75df1b55720fe60c8f74c4eb5e555f5a49f542738d37"
        block = {
            "index": index,
            "message": msg,
            "prev_hash": prev_hash,
            "timestamp": time.time()
        }
        self.chain.append(block)
        return block

    def validate_chain(self):
        """
        Validate the blockchain, returns False if invalid previous hash is found
        Hash each block and compare to the next block's prev_hash, stopping at the last block.
        """
        chain_length = len(self.chain)
        isValid = None

        if(chain_length == 1):
            return "Add blocks and then validate chain."

        for x in range(0, chain_length, 1):
            if(x < chain_length-1):
                # Hash the current block
                hash = self.hash(self.chain[x])
                next_block_prev_hash = self.chain[x+1]['prev_hash']

                if(hash == "0" and x == 0):
                    isValid = True

                if(hash != next_block_prev_hash):
                    isValid = False
                    return isValid
                else:
                    isValid = True

        return isValid

    def hash(self, block):
        # Hash bock
        block_json = json.dumps(block, sort_keys=True).encode(encoding="utf-8")
        block_hash = sha256(block_json).hexdigest()
        return block_hash

    def cache(self):
        # Create local cache of the blockchain
        chain = self.chain
        chain.sort(key = lambda mychain: mychain['index'])
        f = open("cache.json", "w")
        f.write(json.dumps(chain))
        f.close()
        return 1

    def prev_hash(self):
        # Return the previous hash
        return self.hash(self.chain[-1])


