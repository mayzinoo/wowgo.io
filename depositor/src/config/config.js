require('dotenv').config();

module.exports = {
  "DATABASE_URL": process.env.DATABASE_URL || "postgres://postgres:postgres@localhost:5432/wowgodb",
  "GENERATE_ADDRESSES": Number(process.env.GENERATE_ADDRESSES || 100), // how many addresses to watch
  "ETHEREUM_PROVIDER": process.env.ETHEREUM_PROVIDER || jsonRpcProvider,
  "MNEMONIC": process.env.MNEMONIC || 'cherry you receive shuffle ski wise youth roof shield private shaft shield',
  "MINING_FEE": Number(process.env.MINING_FEE || 10000),
  "BIT_TO_ETH_RATIO": Number(process.env.BIT_TO_ETH_RATIO || 1e6)
};
