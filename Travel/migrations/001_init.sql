CREATE TABLE IF NOT EXISTS tours (
    id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    country VARCHAR(64) NOT NULL,
    type VARCHAR(64) NOT NULL,
    price INT NOT NULL,
    nights INT NOT NULL,
    image VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    resort VARCHAR(128) NULL,
    meal VARCHAR(32) NULL,
    hotel_stars TINYINT NULL,
    max_guests TINYINT NULL,
    available_from DATE NULL,
    available_to DATE NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS tour_departures (
    tour_id INT NOT NULL,
    city_code VARCHAR(64) NOT NULL,
    PRIMARY KEY (tour_id, city_code),
    CONSTRAINT fk_tour_departures_tour
        FOREIGN KEY (tour_id) REFERENCES tours(id)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS bookings (
    id INT NOT NULL AUTO_INCREMENT,
    tour_id INT NULL,
    name VARCHAR(128) NOT NULL,
    phone VARCHAR(64) NOT NULL,
    email VARCHAR(255) NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    guests TINYINT NOT NULL,
    note TEXT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    CONSTRAINT fk_bookings_tour
        FOREIGN KEY (tour_id) REFERENCES tours(id)
        ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS newsletter_subscribers (
    id INT NOT NULL AUTO_INCREMENT,
    email VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uniq_newsletter_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS contact_messages (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(128) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(64) NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS admin_users (
    id INT NOT NULL AUTO_INCREMENT,
    email VARCHAR(255) NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uniq_admin_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE INDEX idx_tours_country ON tours(country);
CREATE INDEX idx_tours_type ON tours(type);
CREATE INDEX idx_tours_price ON tours(price);
CREATE INDEX idx_tours_nights ON tours(nights);
CREATE INDEX idx_tours_resort ON tours(resort);
CREATE INDEX idx_tours_meal ON tours(meal);
CREATE INDEX idx_departures_city ON tour_departures(city_code);
