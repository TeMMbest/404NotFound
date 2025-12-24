<?php
require_once '../config/database.php';
requireLogin();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Credits - InventoryHub</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .credits-container {
            max-width: 1000px;
            margin: 0 auto;
        }
        
        .team-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 24px;
            margin-top: 30px;
        }
        
        .team-member-card {
            background: white;
            border-radius: 12px;
            padding: 30px;
            text-align: center;
            box-shadow: var(--shadow);
            transition: transform 0.3s, box-shadow 0.3s;
            border: 2px solid var(--border);
        }
        
        .team-member-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }
        
        .member-icon {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 40px;
            color: white;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }
        
        .member-photo {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            display: block;
        }

        .fallback-icon {
            display: none;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            color: white;
        }

        .member-icon.ai {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }
        
        .member-name {
            font-size: 22px;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 8px;
        }
        
        .member-role {
            font-size: 16px;
            color: var(--primary);
            font-weight: 500;
            padding: 6px 16px;
            background: var(--light);
            border-radius: 20px;
            display: inline-block;
            margin-top: 8px;
        }
        
        .project-title {
            text-align: center;
            margin-bottom: 40px;
            padding: 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 12px;
            color: white;
        }
        
        .project-title h2 {
            font-size: 32px;
            margin-bottom: 10px;
        }
        
        .project-title p {
            font-size: 18px;
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    <?php include 'sidebar.php'; ?>
    
    <main class="main-content">
        <div class="page-header">
            <h1><i class="fas fa-users"></i> Project Members</h1>
            <p>The team behind this project</p>
        </div>
        
        <div class="credits-container">
            <div class="project-title">
                <h2><i class="fas fa-store"></i> InventoryHub</h2>
                <p>Group Project</p>
            </div>
            
            <div class="team-grid">
                <div class="team-member-card">
                    <div class="member-icon">
                        <img src="../assets/images/Jasmine.jpg" alt="Jazmine Turiano" class="member-photo" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'">
                        <i class="fas fa-crown fallback-icon"></i>
                    </div>
                    <div class="member-name">Jazmine Turiano</div>
                    <div class="member-role">Leader</div>
                </div>
                
                <div class="team-member-card">
                    <div class="member-icon">
                        <img src="../assets/images/lawrence.jpg" alt="Lawrence De Quina" class="member-photo" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'">
                        <i class="fas fa-clipboard-list fallback-icon"></i>
                    </div>
                    <div class="member-name">Lawrence De Quina</div>
                    <div class="member-role">Planner</div>
                </div>
                
                <div class="team-member-card">
                    <div class="member-icon">
                        <img src="../assets/images/selwyn.jpg" alt="Selwyn Castillo" class="member-photo" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'">
                        <i class="fas fa-code fallback-icon"></i>
                    </div>
                    <div class="member-name">Selwyn Castillo</div>
                    <div class="member-role">Designer/Developer</div>
                </div>
                
                <div class="team-member-card">
                    <div class="member-icon ai">
                        <img src="../assets/images/gigachad.jpg" alt="ChatGPT" class="member-photo" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'">
                        <i class="fas fa-robot fallback-icon"></i>
                    </div>
                    <div class="member-name">ChatGPT</div>
                    <div class="member-role">Lead Developer/Designer</div>
                </div>
            </div>
            
            <div class="card" style="margin-top: 40px; text-align: center;">
                <div class="card-body">
                    <p style="font-size: 16px; color: var(--muted); margin: 0;">
                        <i class="fas fa-heart" style="color: #dc3545;"></i>
                        We're open for more suggestions and feedback to improve this project!
                    </p>
                </div>
            </div>
        </div>
    </main>
    
    <?php include '../Bot/chatbot.php'; ?>
    <script src="../assets/js/main.js"></script>
</body>
</html>
