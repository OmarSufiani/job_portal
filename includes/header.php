<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}

$username = isset($_SESSION['id_number']) ? $_SESSION['id_number'] : 'User';
?>

<!-- Header Styles -->
<style>
    .header {
        height: 70px;
        background-color: rgb(4, 99, 194);
        color: white;
        padding: 10px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 1000;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }

    .header h1 {
        font-size: 18px;
        margin: 0;
        flex: 1;
        min-width: 150px;
    }

    .user-info {
        font-size: 18px;
        white-space: nowrap;
    }

 .user-info a {
    color: #ecf0f1;
    text-decoration: none;
    margin-left: 5px; /* reduced from 30px */
}


    .user-info a:hover {
        text-decoration: underline;
    }

   .header img {
    height: 70px;              /* Larger logo */
    max-height: 100%;          /* Prevent overflow of header */
    width: auto;
    margin-right: 15px;
    object-fit: contain;       /* Keeps proportions nicely */
}


    .logout-btn {
    background-color: #e74c3c;
    color: white;
    border: none;
    padding: 6px 14px;
    font-size: 14px;
    border-radius: 4px;
    text-decoration: none;
    margin-left: 5px;
    cursor: pointer;
    transition: background-color 0.2s ease;
}

.logout-btn:hover {
    background-color: #c0392b;
}


    /* Responsive shrink */
    @media (max-width: 600px) {
        .header {
            flex-direction: column;
            height: auto;
            align-items: flex-start;
        }

        .user-info {
            margin-top: 5px;
              
        }
    }
</style>

<!-- Header HTML -->
<div class="header">
    <img src="../uploads/bandari.png" alt="Logo" />
    <h1>BANDRI MARITIME ACADEMY</h1>
    <div class="user-info">
        Welcome: <strong><?= htmlspecialchars($username) ?></strong> |
       <a href="../includes/logout.php" class="logout-btn">Logout</a>

    </div>
</div>
