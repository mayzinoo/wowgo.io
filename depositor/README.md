Configuration
=============

### Installing node.js dependencies locally.

This will download and install all dependencies in the `node_modules` subdirectory.

    npm install

### .env file

The following configuration variables need to be set in a .env file in the root directory. see the `example.env` file

### GENERATE_ADDRESSES

How many addresses to watch. `GENERATE_ADDRESSES=1000`

## Generating addresses

This will generate addresses to be watched for deposits

	node src/generate_addresses.js > .addresses.json

### DATABASE_URL

Sets the database connection string. Example:

    DATABASE_URL=postgres://wowgo:<YOURPASSWORD>@localhost/wowgodb

### MNEMONIC

You will need to create a mnemonic and set the MENEMONIC variable in the .env file - A mnemonic is a phrase of 12 random words that will be used to generate a private key, public key, and wallet addresses. Example:

    MNEMONIC=crack giraffe gadget suspect lab enter switch nominee clump symbol hurt end

DON'T SHARE, CHANGE, OR LOOSE THE MNEMONIC OR YOU WILL LOOSE YOUR WALLETS AND ALL USERS FUNDS.

### ETHEREUM_PROVIDER

Set the ETHEREUM_PROVIDER variable in the .env file to your own provider. Example: 
    
    ETHEREUM_PROVIDER=http://mainnet.infura.io/v3/<YOU_PROJECT_KEY>

### MINING_FEE

Sets the mining fee for withdrawals. Example: `MINING_FEE=100`

### BIT_TO_ETH_RATIO

Sets the worth of the house's currency in ether. Example: if 1 ether = 1000000 bits, then `BIT_TO_ETH_RATIO=1000000`

Running
=======

You can run the server by using `npm start`. By default it will listen on port `3842`.
