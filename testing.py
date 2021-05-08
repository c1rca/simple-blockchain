from Blockchain import Blockchain
import json
b = Blockchain()

# Test hash function
hash = b.hash(block={"msg": "hello_world"})
if(hash == "8ad5f739192535bca51fd98a1694c8d24d3892049adf33d19b1f13800f0eb66e"):
    print("Hash test... passed.")
else:
    print("Hash test... FAILED.")

# Test genesis block creation
status = b.genesis()
if(status == "Genesis block created."):
    print("Genesis block test... passed.")
else:
    print("Genesis block test... FAILED.")

# Test chain validation
isValid = b.validate_chain()
print(isValid)
if(isValid == True):
    print("Chain validation test... passed.")
else:
    print("Chain validation test... FAILED.")

# Test get chain
chain = b.get_chain()
if(len(chain) > 0):
    print("Get chain test... passed.")
else:
    print("Get chain test... FAILED.")

# Test new block creation
new_block = b.new_block(msg='example')
print(json.dumps(new_block))
keys = ['index', 'message', 'prev_hash', 'timestamp']
missing = []
for k in keys:
    if k not in new_block:
        missing.append(k)
if(len(missing) > 1):
    print("%s missing from new block." % ",".join(missing))
if(len(missing) == 0):
    print("New block test... passed.")
else:
    print("New block test... FAILED.")

# Test chain validation
isValid = b.validate_chain()
print(isValid)
if(isValid == True):
    print("Chain validation test... passed.")
else:
    print("Chain validation test... FAILED.")

# Insert a rogue block && validate the chain again
rb = b.rogue_block(msg='rogue')
isValid = b.validate_chain()
if(isValid == False):
    print("Rogue block chain validation test... passed.")
else:
    print("Rogue block chain validation test... FAILED.")