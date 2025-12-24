<div class="chatbot-container" id="chatbotContainer">
    <div class="chatbot-toggle" id="chatbotToggle">
        <i class="fas fa-comments"></i>
        <span class="chatbot-badge" id="chatbotBadge" style="display: none;">1</span>
    </div>
    
    <div class="chatbot-window" id="chatbotWindow">
        <div class="chatbot-header">
            <h4><i class="fas fa-robot"></i> Assistant</h4>
            <button class="chatbot-close" id="chatbotClose">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="chatbot-messages" id="chatbotMessages">
            <div class="chatbot-message bot-message">
                <div class="message-content">
                    <p>Hello! I'm your assistant. How can I help you today?</p>
                    <p class="quick-actions">
                        <button class="quick-action-btn" onclick="sendQuickMessage('How do I add an item?')">Add Item</button>
                        <button class="quick-action-btn" onclick="sendQuickMessage('How do I search for items?')">Search Items</button>
                        <button class="quick-action-btn" onclick="sendQuickMessage('What can I do as ' + '<?php echo $_SESSION['position']; ?>' + '?')">My Permissions</button>
                    </p>
                </div>
            </div>
        </div>
        
        <div class="chatbot-input">
            <input type="text" id="chatbotInput" placeholder="Type your message...">
            <button id="chatbotSend">
                <i class="fas fa-paper-plane"></i>
            </button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const chatbotToggle = document.getElementById('chatbotToggle');
    const chatbotWindow = document.getElementById('chatbotWindow');
    const chatbotClose = document.getElementById('chatbotClose');
    const chatbotInput = document.getElementById('chatbotInput');
    const chatbotSend = document.getElementById('chatbotSend');
    const chatbotMessages = document.getElementById('chatbotMessages');
    
    let isOpen = false;
    
    chatbotToggle.addEventListener('click', function() {
        isOpen = !isOpen;
        chatbotWindow.style.display = isOpen ? 'flex' : 'none';
        if (isOpen) {
            chatbotInput.focus();
        }
    });
    
    chatbotClose.addEventListener('click', function() {
        isOpen = false;
        chatbotWindow.style.display = 'none';
    });
    
    function sendMessage() {
        const message = chatbotInput.value.trim();
        if (!message) return;
        
        
        addMessage(message, 'user');
        chatbotInput.value = '';
        
        
        setTimeout(() => {
            const response = getBotResponse(message);
            addMessage(response, 'bot');
        }, 500);
    }
    
    chatbotSend.addEventListener('click', sendMessage);
    chatbotInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            sendMessage();
        }
    });
    
    function addMessage(text, type) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `chatbot-message ${type}-message`;
        
        const contentDiv = document.createElement('div');
        contentDiv.className = 'message-content';
        contentDiv.innerHTML = `<p>${escapeHtml(text)}</p>`;
        
        messageDiv.appendChild(contentDiv);
        chatbotMessages.appendChild(messageDiv);
        chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
    }
    
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
    function getBotResponse(message) {
        const lowerMessage = message.toLowerCase();
        const userPosition = '<?php echo $_SESSION['position']; ?>';
        
        if (lowerMessage.includes('add') && lowerMessage.includes('item')) {
            if (userPosition === 'Admin' || userPosition === 'Encoder') {
                return 'To add an item, go to "Manage Items" from the sidebar, then click "Add New Item" button. Fill in all required fields (Item Name, Price, Quantity) and click "Add Item".';
            } else {
                return 'Sorry, only Admin and Encoder positions can add items. You can view items by going to "View Items" from the sidebar.';
            }
        } else if (lowerMessage.includes('search') || lowerMessage.includes('find')) {
            return 'To search for items, go to "Manage Items" or "View Items" from the sidebar. Use the search box to search by item name, code, or category.';
        } else if (lowerMessage.includes('update') || lowerMessage.includes('edit')) {
            if (userPosition === 'Admin' || userPosition === 'Encoder') {
                return 'To update an item, go to "Manage Items", find the item you want to edit, and click the "Edit" button. Make your changes and click "Update Item".';
            } else {
                return 'Sorry, only Admin and Encoder positions can edit items.';
            }
        } else if (lowerMessage.includes('delete') || lowerMessage.includes('remove')) {
            if (userPosition === 'Admin' || userPosition === 'Encoder') {
                return 'To delete an item, go to "Manage Items", find the item you want to delete, and click the "Delete" button. You will be asked to confirm before deletion.';
            } else {
                return 'Sorry, only Admin and Encoder positions can delete items.';
            }
        } else if (lowerMessage.includes('permission') || lowerMessage.includes('can i do') || lowerMessage.includes('what can')) {
            if (userPosition === 'Admin') {
                return 'As an Admin, you can: Manage Items (Add, Edit, Delete, Search), Manage Users (Add, Edit, Delete), and View all items.';
            } else if (userPosition === 'Encoder') {
                return 'As an Encoder, you can: Manage Items (Add, Edit, Delete, Search) and View all items.';
            } else {
                return 'As a Viewer, you can only view items. You cannot add, edit, or delete items or users.';
            }
        } else if (lowerMessage.includes('user') && (lowerMessage.includes('add') || lowerMessage.includes('manage'))) {
            if (userPosition === 'Admin') {
                return 'To manage users, go to "Manage Users" from the sidebar. Only Admin can add, edit, or delete users.';
            } else {
                return 'Sorry, only Admin can manage users.';
            }
        } else if (lowerMessage.includes('hello') || lowerMessage.includes('hi') || lowerMessage.includes('hey')) {
            return 'Hello! How can I assist you today? You can ask me about adding items, searching, updating, or your permissions.';
        } else if (lowerMessage.includes('help')) {
            return 'I can help you with: Adding items, Searching items, Updating items, Deleting items, Understanding your permissions, and Navigating the system. What would you like to know?';
        } else {
            return 'I understand you\'re asking about: "' + message + '". Could you be more specific? I can help with item management, user management (Admin only), and system navigation.';
        }
    }
    
    window.sendQuickMessage = function(message) {
        chatbotInput.value = message;
        sendMessage();
    };
});
</script>
