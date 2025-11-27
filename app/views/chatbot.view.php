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
            <div id="qa-container" class="qa-container">
                <div class="welcome-message">
                    <p>Hei! Jeg er UIA chatbot, din personlige assistent. Hvordan kan jeg hjelpe deg i dag?</p>
                    <div class="quick-actions">
                        <button class="quick-action">Hvordan finner jeg fram?</button>
                        <button class="quick-action">Når er eksamen? </button>
                        <button class="quick-action">Hvilke aktiviteter finnes?</button>
                        <button class="quick-action">Hvilke aktiviteter finnes?</button>
                        <button class="quick-action">Hvilke aktiviteter finnes?</button>
                    </div>
                </div>
                    <?php 
                        if (isset($_SESSION['chatbotLog'])) {
                            foreach ($chatbotLog as $QAArr) {
                                $question = htmlspecialchars($QAArr[0], ENT_QUOTES, 'UTF-8');
                                $answer   = htmlspecialchars($QAArr[1], ENT_QUOTES, 'UTF-8');
                                ?>

                                <!-- User message -->
                                <div class="message user">
                                    <div class="message-bubble">
                                        <?php echo $question; ?>
                                        <div class="message-time">
                                            <!-- optionally print time here -->
                                        </div>
                                    </div>
                                </div>

                                <!-- Bot message -->
                                <div class="message bot">
                                    <div class="message-bubble">
                                        <?php echo $answer; ?>
                                        <div class="message-time">
                                            <!-- optionally print time here -->
                                        </div>
                                    </div>
                                </div>

                            <?php
                            }
                        }
                    ?>
            </div>
        </div>
        
        <form class="input-area" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
            <div class="input-wrapper">
                <input type="text" class="message-input" name="question" placeholder="Skriv din melding..." required>
            </div>
            <button class="send-button" name="ChatbotQ" type="submit">
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
    </script>

