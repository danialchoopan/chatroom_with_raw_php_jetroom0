-- Create Users Table
CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(20) DEFAULT 'user',
    is_blocked INTEGER DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create Rooms Table
CREATE TABLE IF NOT EXISTS rooms (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(100) NOT NULL,
    description TEXT
);

-- Create Messages Table
CREATE TABLE IF NOT EXISTS messages (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER NOT NULL,
    room_id INTEGER NOT NULL,
    message TEXT,
    image_path VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (room_id) REFERENCES rooms(id)
);

-- Create Private Messages Table
CREATE TABLE IF NOT EXISTS private_messages (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    sender_id INTEGER NOT NULL,
    receiver_id INTEGER NOT NULL,
    message TEXT,
    image_path VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (sender_id) REFERENCES users(id),
    FOREIGN KEY (receiver_id) REFERENCES users(id)
);

-- Insert 10 Default Rooms
INSERT OR IGNORE INTO rooms (id, name, description) VALUES (1, 'عمومی', 'اتاقی برای گفتگوهای عمومی');
INSERT OR IGNORE INTO rooms (id, name, description) VALUES (2, 'برنامه‌نویسی', 'بحث و تبادل نظر در مورد دنیای کدنویسی');
INSERT OR IGNORE INTO rooms (id, name, description) VALUES (3, 'سرگرمی', 'جوک، طنز و مطالب سرگرم‌کننده');
INSERT OR IGNORE INTO rooms (id, name, description) VALUES (4, 'سخت‌افزار', 'گفتگو در مورد قطعات کامپیوتر و گجت‌ها');
INSERT OR IGNORE INTO rooms (id, name, description) VALUES (5, 'هوش مصنوعی', 'اخبار و تکنولوژی‌های AI');
INSERT OR IGNORE INTO rooms (id, name, description) VALUES (6, 'بازی‌های ویدئویی', 'گیمینگ و کنسول‌ها');
INSERT OR IGNORE INTO rooms (id, name, description) VALUES (7, 'طراحی گرافیک', 'هنر دیجیتال و طراحی');
INSERT OR IGNORE INTO rooms (id, name, description) VALUES (8, 'امنیت و شبکه', 'هک، امنیت و مباحث شبکه');
INSERT OR IGNORE INTO rooms (id, name, description) VALUES (9, 'موسیقی', 'اشتراک‌گذاری آهنگ و هنرمندان');
INSERT OR IGNORE INTO rooms (id, name, description) VALUES (10, 'فیلم و سریال', 'نقد و بررسی فیلم‌های روز');
