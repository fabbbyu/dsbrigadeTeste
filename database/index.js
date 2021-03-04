async function connect() {
    if (global.connection)
        return global.connection.connect();

    const { Pool } = require('pg');
    const pool = new Pool({
        connectionString: 'postgres://'+process.env.DB_USERNAME+':'+process.env.DB_PASSWORD+'@'+process.env.DB_HOST+':'+process.env.DB_PORT+'/'+process.env.DB_DATABASE
    });

    const client = await pool.connect();

    global.connection = pool;
    return pool.connect();
}

async function insertDB(data){
    const client = await connect();
    const sql = 'INSERT INTO noticias(fonte,url,titulo,subtitulo,data_pub,data_coleta,texto,tags) VALUES ($1,$2,$3,$4,$5,$6,$7,$8);';
    const values = [data.fonte, data.url, data.titulo, data.subtitulo, data.data_pub, data.data_coleta, data.texto, data.tags];
    return await client.query(sql, values);
}

async function selectDB() {
    const client = await connect();
    const res = await client.query('SELECT * FROM noticias');
    return res.rows;
}

exports.insertDB = insertDB;
exports.selectDB = selectDB;

//connect()