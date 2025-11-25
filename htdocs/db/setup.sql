-- Create books table for Library Management System
CREATE TABLE IF NOT EXISTS books (
    bookid INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255) NOT NULL,
    isbn VARCHAR(50),
    publisher VARCHAR(255),
    year INT,
    category VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert sample data
INSERT INTO books (title, author, isbn, publisher, year, category) VALUES
('The Great Gatsby', 'F. Scott Fitzgerald', '978-0-7432-7356-5', 'Scribner', 1925, 'Fiction'),
('To Kill a Mockingbird', 'Harper Lee', '978-0-06-112008-4', 'J.B. Lippincott & Co.', 1960, 'Fiction'),
('1984', 'George Orwell', '978-0-452-28423-4', 'Secker & Warburg', 1949, 'Science Fiction'),
('Pride and Prejudice', 'Jane Austen', '978-0-19-953556-9', 'T. Egerton', 1813, 'Romance'),
('The Catcher in the Rye', 'J.D. Salinger', '978-0-316-76948-0', 'Little, Brown and Company', 1951, 'Fiction'),
('Harry Potter and the Sorcerer''s Stone', 'J.K. Rowling', '978-0-439-70818-8', 'Bloomsbury', 1997, 'Fantasy'),
('The Hobbit', 'J.R.R. Tolkien', '978-0-547-92822-7', 'George Allen & Unwin', 1937, 'Fantasy'),
('Fahrenheit 451', 'Ray Bradbury', '978-1-451-67331-9', 'Ballantine Books', 1953, 'Science Fiction'),
('Brave New World', 'Aldous Huxley', '978-0-06-085052-4', 'Chatto & Windus', 1932, 'Science Fiction'),
('The Lord of the Rings', 'J.R.R. Tolkien', '978-0-618-57498-0', 'George Allen & Unwin', 1954, 'Fantasy');
