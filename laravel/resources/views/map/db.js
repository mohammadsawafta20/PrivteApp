
const mysql = require('mysql2/promise');

// إنشاء connection pool
const pool = mysql.createPool({
    host: '127.0.0.1',
    user: 'root',
    password: '',
    database: 'delivery_system',
    waitForConnections: true,
    connectionLimit: 10,
    queueLimit: 0
});

// دالة للتحقق من الاتصال
async function testConnection() {
    let connection;
    try {
        connection = await pool.getConnection();
        console.log('✅ تم الاتصال بنجاح مع قاعدة البيانات');
        return true;
    } catch (error) {
        console.error('❌ فشل الاتصال بقاعدة البيانات:', error.message);
        return false;
    } finally {
        if (connection) connection.release();
    }
}

module.exports = { pool, testConnection };
