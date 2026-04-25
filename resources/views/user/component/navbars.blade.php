<style>
@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.2); }
    100% { transform: scale(1); }
}

/* ================= NAVBAR MODERN ================= */
.navbar {
    position: sticky;
    top: 0;
    width: 100%;
    backdrop-filter: blur(14px);
    background: linear-gradient(135deg, rgba(10,20,80,0.85), rgba(40,0,80,0.85));
    border-bottom: 1px solid rgba(255,255,255,0.08);
    color: white;
    padding: 8px 16px;
    font-size: 0.8rem;
    z-index: 1000;

    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
}

/* LOGO */
.logo-container {
    display: flex;
    align-items: center;
    gap: 8px;
}

.logo-img {
    width: 38px;
    height: 38px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
    background: linear-gradient(135deg, rgba(99,102,241,0.2), rgba(168,85,247,0.2));
    border: 1px solid rgba(99,102,241,0.4);
    font-size: 18px;
}

.logo-text h1 {
    font-size: 0.9rem;
    margin: 0;
    font-weight: 600;
}

.logo-text span {
    font-size: 0.65rem;
    color: rgba(255,255,255,0.6);
}

/* MENU */
.navbar nav ul {
    display: flex;
    gap: 6px;
    list-style: none;
    margin: 0;
    padding: 0;
}

.navbar nav ul li a {
    color: #e0e7ff;
    text-decoration: none;
    padding: 6px 10px;
    border-radius: 8px;
    transition: all 0.25s ease;
}

.navbar nav ul li a:hover {
    background: rgba(99,102,241,0.2);
    color: #fff;
}

/* DROPDOWN */
.dropdown-menu {
    display: none;
    position: absolute;
    top: 110%;
    left: 0;
    background: rgba(20,20,60,0.95);
    backdrop-filter: blur(12px);
    border-radius: 12px;
    padding: 6px 0;
    min-width: 180px;
    border: 1px solid rgba(255,255,255,0.08);
    box-shadow: 0 10px 25px rgba(0,0,0,0.3);
}

.navbar nav ul li:hover > .dropdown-menu {
    display: block;
}

.dropdown-menu li a {
    padding: 8px 12px;
    display: block;
    border-radius: 6px;
}

.dropdown-menu li a:hover {
    background: rgba(99,102,241,0.25);
}

/* SUBMENU */
.submenu {
    left: 100%;
    top: 0;
}

/* SEARCH */
.navbar form {
    display: flex;
    gap: 6px;
    align-items: center;
}

.navbar form input,
.navbar form select {
    padding: 6px 8px;
    border-radius: 8px;
    border: 1px solid rgba(255,255,255,0.2);
    background: rgba(255,255,255,0.05);
    color: white;
    font-size: 0.75rem;
}

.navbar form input::placeholder {
    color: rgba(255,255,255,0.5);
}

.navbar form button {
    padding: 6px 10px;
    border-radius: 8px;
    border: none;
    background: linear-gradient(135deg, #6366f1, #a855f7);
    color: white;
    cursor: pointer;
    transition: 0.3s;
}

.navbar form button:hover {
    opacity: 0.85;
}

/* USER AREA */
.user-area button {
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.1);
    padding: 6px 10px;
    border-radius: 10px;
    color: #facc15;
}

/* NOTIF */
#notif-badge {
    animation: pulse 1s infinite;
}

/* RESPONSIVE */
@media (max-width: 768px) {
    .navbar {
        flex-direction: column;
        align-items: flex-start;
    }

    .navbar nav ul {
        flex-direction: column;
        width: 100%;
    }

    .navbar form {
        width: 100%;
        margin-top: 8px;
        flex-wrap: wrap;
    }

    .navbar form input,
    .navbar form select,
    .navbar form button {
        width: 48%;
    }

    .navbar form button {
        width: 100%;
    }

    .dropdown-menu {
        position: relative;
    }

    .submenu {
        left: 0;
    }
}
</style>
