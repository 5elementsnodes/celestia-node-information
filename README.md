**Celestia Node Information** is a telegram chatbot that allows you to make rpc calls to the celestia full node of 5 Elements Nodes.
It is currently active [here](https://telegram.me/celestia_nodeinfo_bot).
Developed in php and hooked to the telegram api through webhooks. 
For more details regarding the telegram API, see the following [documentation](https://core.telegram.org/bots/api#getting-updates).

The following commands are currently available:

**/help** - List of the commands
**/balance** - Node's balance 
**/balance**_address - Address balance 
**/head** - Last chain height
**/header_number** - Specific block height
**/celestia** - Learn what is Celestia

If you want to use it for your node you need to make the following changes:

- set **$nodeurl** with the url of your fullnode
- set **$token** with your chatbot's token, created thanks to [BotFather](https://telegram.me/BotFather)
