SET NAMES utf8mb4;
SET CHARACTER SET utf8mb4;

DROP TABLE IF EXISTS gwent_decks;
DROP TABLE IF EXISTS meetings;
DROP TABLE IF EXISTS monsters;

CREATE TABLE monsters (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    location VARCHAR(255) NOT NULL,
    danger_level VARCHAR(50) NOT NULL,
    description TEXT
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE meetings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    date DATETIME NOT NULL,
    location VARCHAR(255) NOT NULL,
    topic VARCHAR(255) NOT NULL,
    description TEXT
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE gwent_decks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    faction VARCHAR(100) NOT NULL,
    playstyle VARCHAR(255) NOT NULL,
    description TEXT
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert dummy data
INSERT INTO monsters (name, location, danger_level, description) VALUES
('Polednice', 'Krušné hory', 'Vysoké', 'Objevuje se kolem poledne na polích.'),
('Utopenec', 'Labe - Děčín', 'Nízké', 'Číhá u vody, nebezpečný hlavně v noci.'),
('Gryf', 'Milešovka', 'Kritické', 'Velký létající netvor. Útočí ze vzduchu.');

INSERT INTO meetings (date, location, topic, description) VALUES
('2024-05-15 18:00:00', 'Hospoda U Prasklého štítu, Ústí nad Labem', 'Příprava na sezónu upírů', 'Budeme probírat výrobu olejů a bezpečné hlídky v noci.'),
('2024-06-20 15:00:00', 'Zřícenina hradu Střekov', 'Obrana proti harpyjím', 'Praktická ukázka zbraní a lukostřelby.');

INSERT INTO gwent_decks (faction, playstyle, description) VALUES
('Severní říše', 'Obléhání a špioni', 'Specializuje se na silné obléhací stroje a využívání špionů pro získání karetní výhody.'),
('Nilfgaard', 'Diplomacie a kontrola', 'Spoléhá na velký počet špionů, rušení soupeřových plánů a silné hrdiny.'),
('Scoia''tael', 'Agilita a léčky', 'Flexibilní jednotky schopné boje zblízka i na dálku. Velká podpora léčitelů a mediků.'),
('Příšery', 'Hrubá síla a rojení', 'Ignoruje diplomacii ve prospěch obrovských čísel. Schopnost povolat na bojiště celé roje netvorů.'),
('Skellige', 'Bouře a berserkové', 'Zaměřuje se na posilování jednotek poškozením, oživování a proměny v berserky za pomoci Mardroeme.');
