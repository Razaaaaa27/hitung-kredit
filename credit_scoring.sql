CREATE TABLE applicants (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    age INT NOT NULL,
    marital_status ENUM('Belum Menikah', 'Menikah', 'Janda/Duda') NOT NULL,
    dependents INT NOT NULL,
    occupation VARCHAR(50) NOT NULL,
    collateral ENUM('Rumah', 'Mobil', 'Sepeda motor', 'Tidak ada') NOT NULL,
    income DECIMAL(65, 2) NOT NULL,
    score INT NOT NULL,
    decision VARCHAR(50) NOT NULL,
    application_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);