<link rel="stylesheet" href="./CSS/chatbot.css?v=<?php echo time(); ?>">

 <div class="chat-container">
        <header class="chat-header">
            <div class="bot-avatar"><img src="images/b766525f-460d-42ee-9fc3-0dcfd752952a-Photoroom.png" alt=""></div>
            <div class="bot-info">
                <h1 class="bot-name">UIA Chatbot</h1>
                <div class="bot-status">
                    <span class="status-dot"></span>
                    <span>Klar til å hjelpe</span>
                </div>
            </div>
        </header>
        <div class="messages-container" id="messagesContainer">
            <div class="welcome-message">
                <p>Hei! Jeg er UIA chatbot, din personlige assistent. Hvordan kan jeg hjelpe deg i dag?</p>
                <div class="quick-actions">
                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>">
                        <button class="quick-action" id="quick-action1" name="quickQuestion" value="1">Hvordan finner jeg fram?</button>
                        <button class="quick-action" id="quick-action2" name="quickQuestion" value="2">Når er eksamen?</button>
                        <button class="quick-action" id="quick-action3" name="quickQuestion" value="3">Hvilke aktiviteter finnes?</button>
                        <button class="quick-action" id="quick-action4" name="quickQuestion" value="4">Hvor ligger Uia?</button>
                        <button class="quick-action" id="quick-action5" name="quickQuestion" value="5">Finnes det parkeringsplass?</button>
                    </form>
                </div>
            </div>
            <div id="qa-container" class="qa-container">
                <?php 
                    if(isset($_SESSION['chatbotLog'])){
                        foreach($_SESSION['chatbotLog'] as $QAArr){
                            foreach($QAArr as $innerArr){ // $innerArr is the array with [0] => question, [1] => answer
                                echo "<div class='qa-item'>";
                                echo "<p class='question'>Spørsmål: " . htmlspecialchars($innerArr[0]) . "</p>";
                                echo "<p class='answer'>Svar: " . htmlspecialchars($innerArr[1]) . "</p>";
                                echo "</div>";
                            }
                        }
                    } 
                ?>
            </div>
            <div>
                <img id="chatThinking" src="images/07-57-40-974_512.webp" alt="Chatbot is thinking..." >
            </div>
        </div>
        
        <form class="input-area" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
            <div class="input-wrapper">
                <input type="text" id="message-input" class="message-input" name="question" placeholder="Skriv din melding..." required>
            </div>
            <button class="send-button" name="ChatbotQ" type="submit" id="btnChatbot" onclick="showThinking()">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 2L11 13"></path>
                    <path d="M22 2L15 22L11 13L2 9L22 2Z"></path>
                </svg>
            </button>

        </form>
        </div>
    </div>
    <script>
        const container = document.getElementById('qa-container');
        container.scrollTop = container.scrollHeight;

        function showThinking() {
            input = document.getElementById('message-input');
            if(input.value.trim() === ""){
                return; // do nothing if empty
            } else{
                /* Access image by id and change 
                the display property to block*/
                document.getElementById('chatThinking')
                .style.opacity = "1";
            }
            
        }
    </script>

