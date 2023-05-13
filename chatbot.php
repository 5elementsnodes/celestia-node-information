<?php
    //functions
    include 'functions/functions.php';

    $token = "YOUR_TOKEN";
    $website = "https://api.telegram.org/bot".$token;

    $updates = file_get_contents("php://input");
    $updates = json_decode($updates, TRUE);

    //if the request is null stop to the script
    if(!$updates) {
        exit;
    }

    // variables
    $text = $updates["message"]["text"];
    $chatID = $updates["message"]["chat"]["id"];
    $message = $updates['message']  ?? null;
    $url = "https://api.telegram.org/bot$token/sendMessage";
    $nodeurl = 'YOUR_FULLNODE_ADDRESS';

    $text = strtolower($text);

    if ($text == strstr($text, '/balance_')){
        $address_wallet=str_replace("/balance_","", $text);
        if ($address_wallet == "address"){
            $address_wallet = null;
        }
        $text = "/balance_";
    }

    if ($text == strstr($text, '/header_')){
        $header_number=str_replace("/header_","", $text);
        if ($header_number == "address"){
            $header_number = null;
        }
        $text = "/header_";
    }

    switch($text){
        case "/start":
        case "/help":
            sendMessage($chatID, "Welcome on the <b>Celestia Node Info</b>, this is the list of the commands:\n\n\n/help - List of the commands\n/balance - Node's balance \n/balance_address - Address balance\n/head - Last chain height\n/header_number - Specific block height\n/celestia - Learn what is Celestia");
        break;
        case "/balance":
            $curl = curl_init($nodeurl."balance");
            curl_setopt($curl, CURLOPT_URL, $nodeurl."balance");
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            
            //for debug only!
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            
            $resp = curl_exec($curl);
            curl_close($curl);
            $resp_array = json_decode($resp, true);
            // divide "amount" by 1,000,000 and format result with 6 decimal places
            $amount = number_format(bcdiv($resp_array["amount"], "1000000", 6), 6);

            // replace "denom" with "TIA"
            $denom = "TIA";

            sendMessage($chatID,"The node's <b>balance</b> is <b>$amount.$denom</b>.");
            sendMessage($chatID, "If you want to know a balance for a specific address use <b>/balance_address</b> command.\nFor example <b>/balance_celestia1fv59j8hhmh4eerlf6fy32jlf6mhmw867l6cr28</b>.");
        break;
        case "/balance_":
            if ($address_wallet == null){
                sendMessage($chatID, "You must indicate a valid address.\n\nFor example: <b>/balance_celestia1fv59j8hhmh4eerlf6fy32jlf6mhmw867l6cr28</b>\n\n A valid address should start with <b>celestia</b> followed by a hexadecimal string e.g <b><a href='https://testnet.mintscan.io/celestia-incentivized-testnet/account/celestia1fv59j8hhmh4eerlf6fy32jlf6mhmw867l6cr28'>celestia1fv59j8hhmh4eerlf6fy32jlf6mhmw867l6cr28</a></b>");
            }
            else{
                if (!strstr($address_wallet, 'celestia')){
                    sendMessage($chatID, "Are you sure you entered a valid address? A valid address should start with <b>celestia</b> followed by a hexadecimal string e.g <b><a href='https://testnet.mintscan.io/celestia-incentivized-testnet/account/celestia1fv59j8hhmh4eerlf6fy32jlf6mhmw867l6cr28'>celestia1fv59j8hhmh4eerlf6fy32jlf6mhmw867l6cr28</a></b>.");
                }
                else{
                    
                    $curl = curl_init($nodeurl."balance/".$address_wallet);
                    curl_setopt($curl, CURLOPT_URL, $nodeurl."balance/".$address_wallet);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    
                    //for debug only!
                    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
                    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                    
                    $resp = curl_exec($curl);
                    curl_close($curl);
                    $resp_array = json_decode($resp, true);

                    // divide "amount" by 1,000,000 and format result with 6 decimal places
                    $amount = number_format(bcdiv($resp_array["amount"], "1000000", 6), 6);

                    // replace "denom" with "TIA"
                    $denom = "TIA";
                    sendMessage($chatID, "Balance for <b>$address_wallet</b> is <b>$amount.$denom</b>.");
                    sendMessage($chatID, "<a href='https://testnet.mintscan.io/celestia-incentivized-testnet/account/$address_wallet'>Link on the explorer</a>.");
                   
                }
            }
        break;
        case "/celestia":
            sendMessage($chatID, "Celestia is the First Modular Blockchain network which enables developers to deploy their own blockchain as easy as deploying a new smart contract. Would you like to know more? <a href='https://docs.celestia.org/'>Click here</a>");
        break;
        case "/head":
            sendMessage($chatID, "Last chain height.");
        
            $curl = curl_init($nodeurl."head");
            curl_setopt($curl, CURLOPT_URL, $nodeurl."head");
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        
            $resp = curl_exec($curl);
            curl_close($curl);
        
            $resp_array = json_decode($resp, true);
        
            $chain_id = $resp_array['header']['chain_id'];
            $height = $resp_array['header']['height'];
            $time = $resp_array['header']['time'];
            $num_signatures = count($resp_array['commit']['signatures']);
        
            $message = "Chain ID:<b> $chain_id</b>\nHeight: <a href='https://testnet.mintscan.io/celestia-incentivized-testnet/blocks/$height'><b>$height</b></a>\nTime: <b>$time</b>\nNumber of signatures: <b>$num_signatures</b>";
            sendMessage($chatID, $message);
            sendMessage($chatID, "If you want to watch a specific height block use the <b>/header_number</b> command.\nFor example <b>/header_500</b>.");
        
            break; 
            case "/header_":
                $curl = curl_init($nodeurl."head");
                curl_setopt($curl, CURLOPT_URL, $nodeurl."head");
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            
                $resp = curl_exec($curl);
                curl_close($curl);
            
                $resp_array = json_decode($resp, true);
                $height = $resp_array['header']['height'];
                if (!$header_number == null && is_numeric($header_number) && $header_number <= $height){
                    $curl = curl_init($nodeurl."header/".$header_number);
                    curl_setopt($curl, CURLOPT_URL, $nodeurl."header/".$header_number);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                                    
                    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
                    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                                                
                    $resp = curl_exec($curl);
                    curl_close($curl);
                                                
                    $resp_array = json_decode($resp, true);
                                                
                    $chain_id = $resp_array['header']['chain_id'];
                    $height = $resp_array['header']['height'];
                    $time = $resp_array['header']['time'];
                    $num_signatures = count($resp_array['commit']['signatures']);
                                                
                    $message = "Chain ID: <b>$chain_id</b>\nHeight: <a href='https://testnet.mintscan.io/celestia-incentivized-testnet/blocks/$height'><b>$height</b></a>\nTime: <b>$time</b>\nNumber of signatures: <b>$num_signatures</b>";
                    sendMessage($chatID, $message);
                    sendMessage($chatID, "If you want to know what is the number of the last block digit the <b>/head</b> command.");
                }
                else{
                    sendMessage($chatID, "Are you sure you entered a valid header number? The last height of the block is <b>$height</b>.\n\nFor example: <b>/header_420</b>");
                }
            break;
        default:
            sendMessage($chatID, "I'm sorry but I don't understand. Digit <b>/help</b> for the list of the commands.");
        break;
    }
?>
