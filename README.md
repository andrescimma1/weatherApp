# WeatherApp Database Setup
This project requires a MySQL database named weatherapp and a table named cached_weathers to store cached weather data.

Table Structure
cached_weathers
This table is used to store cached weather data for different cities.

Columns
id: Integer, Auto-increment, Primary Key
city_name: VARCHAR(255), Not Null
weather_data: JSON, Not Null
created_at: Timestamp, Default: Current Timestamp
updated_at: Timestamp, Default: Current Timestamp on Update Current Timestamp
SQL Script
To create the cached_weathers table, use the following SQL script:

sql
Copy code
CREATE TABLE cached_weathers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    city_name VARCHAR(255) NOT NULL,
    weather_data JSON NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
This README provides instructions to set up the necessary database structure for the WeatherApp project. You can run the SQL script provided to create the required table. Adjust the database configuration in the project accordingly to connect to the weatherapp database.

Feel free to customize this README based on your project's specific requirements and add any additional setup or configuration instructions.
