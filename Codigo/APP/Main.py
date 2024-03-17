from flask import Flask, render_template, request, redirect, url_for, session
import mysql.connector

app = Flask(__name__)

# Conexão com o banco de dados
db = mysql.connector.connect(
    host="localhost",
    user="vitor",
    password="40028922",
    database="nome_do_banco_de_dados",
    auth_plugin='mysql_native_password'  # Use mysql_native_password para autenticação
)

# Rota para a HOME
@app.route("/")
def home():
    return render_template('index.html')

# Rota para os CONTATOS
@app.route("/contatos")
def contatos():
    return "Contato"   

# Rota para usuários
@app.route("/usuario")
def usuario():
    return render_template('usuarios.html')

# Página de cadastro de cliente 
@app.route('/register', methods=['GET','POST'])
def register():
    if request.method == 'POST':
        nome = request.form['nome']
        username = request.form['username']
        password = request.form['password']
        
        # Debug: Imprimir os valores
        print("Nome:", nome)
        print("Username:", username)
        print("Password:", password)

        # Inserindo dados no banco de dados
        cursor = db.cursor()
        cursor.execute('INSERT INTO usuarios (nome, username, senha) VALUES (%s, %s, %s)', (nome, username, password))
        db.commit()

        return 'Registro bem-sucedido!'
    else:
        return render_template('register.html')

# Página de login
@app.route('/login', methods=['GET','POST'])
def login():
    return render_template('login.html')

# Colocar o site no ar
if __name__ == "__main__":
    app.run(debug=True)
