<!-- <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST">

Question: <input type="text" name='question' value="Når er Matte prøve test">
Submit: <input type="submit">

</form> -->

<link rel="stylesheet" href="./CSS/chatbot.css">

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
                    <button class="quick-action">Hvordan finner jeg fram?</button>
                    <button class="quick-action">Når er eksamen? </button>
                    <button class="quick-action">Hvilke aktiviteter finnes?</button>
                    <button class="quick-action">Hvilke aktiviteter finnes?</button>
                    <button class="quick-action">Hvilke aktiviteter finnes?</button>
                </div>
            </div>
        </div>
        <form class="input-area" 
            action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" 
            method="POST">
            <div class="input-wrapper">
                <input type="text" class="message-input" name="question" placeholder="Skriv din melding..." required>
            </div>
            <button class="send-button" type="submit">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 2L11 13"></path>
                    <path d="M22 2L15 22L11 13L2 9L22 2Z"></path>
                </svg>
            </button>

        </form>
        </div>
    </div>
