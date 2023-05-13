# Celestia Node Information

It's a simple telegram chatbot that allows you to make rpc calls to the celestia full node of 5 Elements Nodes.

### How to Use

How to use it is extremely simple, just have a telegram account and start a conversation with the chabot.\
It is currently active [here](https://telegram.me/celestia_nodeinfo_bot).

#### Available Commands

**/help** - List of the commands\
**/balance** - Node's balance\
**/balance**_address - Address balance\
**/head** - Last chain height\
**/header_number** - Specific block height\
**/celestia** - Learn what is Celestia

### Setup

If you want to use this chatbot for your own node, you will need to make the following changes:

1. Set $nodeurl with the URL of your full node.
2. Set $token with your chatbot's token, which can be created using [BotFather](https://telegram.me/BotFather)

### Technologies Used

Developed in php and hooked to the telegram api through webhooks.\ 
For more details regarding the telegram API, see the following [documentation](https://core.telegram.org/bots/api#getting-updates).

### Dependencies
No dependencies

### Contributing
If you would like to contribute to this repository, please create a fork of the repository and submit a pull request with your proposed changes. Before submitting your pull request, please ensure that your code adheres to the existing code style and is well-documented.

### License
This repository is licensed under the MIT license. You are free to use this code for any purpose, commercial or non-commercial, as long as you include the original copyright notice and license text in any copies or derivative works.
