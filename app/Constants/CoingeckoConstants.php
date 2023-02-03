<?php

namespace App\Constants;

class CoingeckoConstants
{
    const COIN_GECKO_SERVICE_GET_ENDPOINT_TO_GET_ASSETS = 'CoinGeckoService#getEndpointToGetAssets';
    const COIN_GECKO_SERVICE_GET_ENDPOINT_TO_LIST_ASSETS = 'CoinGeckoService#getEndpointToListAssets';
    const COIN_GECKO_SERVICE_GET_ENDPOINT_TO_GET_SIMPLE_PRICE = 'CoinGeckoService#getEndpointToGetSimplePrice';
    const COIN_GECKO_SERVICE_GET_ENDPOINT_TO_GET_ASSET_HISTORY = 'CoinGeckoService#getEndpointToGetAssetHistory';
    const COIN_GECKO_SERVICE_GET_ENDPOINT_TO_GET_ASSETS_MARKET = 'CoinGeckoService#getEndpointToGetAssetsMarket';

    const DEFAULT_ERROR_MESSAGE = 'Something unexpected happened. If the problem persists, contact support.';

    static function getErrorMessage($errorCode)
    {
        return self::DEFAULT_ERROR_MESSAGE;
    }

    const MARKET_LIST_PER_PAGE = 200;
    const MARKET_LIST_TOTAL_PAGES = 5;

    // const ASSETS_COIN_GECKO_ID = [
    //     "bitcoin",
    //     "ethereum",
    //     "tether",
    //     "bnb",
    //     "usd-coin",
    //     "binance-usd",
    //     "xrp",
    //     "cardano",
    //     "dogecoin",
    //     "polygon",
    //     "polkadot",
    //     "dai",
    //     "shiba-inu",
    //     "lido-staked-ether",
    //     "tron",
    //     "solana",
    //     "okb",
    //     "wrapped-bitcoin",
    //     "uniswap",
    //     "avalanche",
    //     "litecoin",
    //     "leo-token",
    //     "chainlink",
    //     "cosmos-hub",
    //     "ethereum-classic",
    //     "stellar",
    //     "cronos",
    //     "monero",
    //     "the-open-network",
    //     "algorand",
    //     "bitcoin-cash",
    //     "near",
    //     "quant",
    //     "vechain",
    //     "filecoin",
    //     "flow",
    //     "frax",
    //     "terra-luna-classic",
    //     "hedera",
    //     "internet-computer",
    //     "apecoin",
    //     "multiversx",
    //     "tezos",
    //     "theta-network",
    //     "chain",
    //     "chiliz",
    //     "the-sandbox",
    //     "decentraland",
    //     "aave",
    //     "eos",
    //     "compound-usd-coin",
    //     "pax-dollar",
    //     "huobi-token",
    //     "gemini-dollar",
    //     "true-usd",
    //     "kucoin-shares",
    //     "lido-dao",
    //     "tokenize-xchange",
    //     "bitcoin-sv",
    //     "axie-infinity",
    //     "whitebit",
    //     "usdd",
    //     "bittorrent",
    //     "ecash",
    //     "maker",
    //     "gatetoken",
    //     "iota",
    //     "pancakeswap",
    //     "osmosis",
    //     "btse-token",
    //     "aptos",
    //     "compound-dai",
    //     "pax-gold",
    //     "klaytn",
    //     "radix",
    //     "arweave",
    //     "zcash",
    //     "neo",
    //     "fantom",
    //     "the-graph",
    //     "evmos",
    //     "synthetix-network-token",
    //     "nexo",
    //     "ftx-token",
    //     "compound-ether",
    //     "trust-wallet-token",
    //     "tether-gold",
    //     "ethereumpow",
    //     "mina-protocol",
    //     "xdc-network",
    //     "dash",
    //     "basic-attention-token",
    //     "frax-share",
    //     "helium",
    //     "thorchain",
    //     "zilliqa",
    //     "curve-dao-token",
    //     "enjin-coin",
    //     "casper-network",
    //     "1inch",
    //     "matic-network",
    //     "polymath",
    //     "ripple",
    //     "terrausd",
    //     "terra-luna-2"
    // ];

}
