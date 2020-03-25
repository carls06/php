create database db_farmacia
go
use db_farmacia
go
/*Tabla de Usuario*/
create table usuario
(id_usuario int identity(1,1) primary key,
usuario varchar(20) not null,
contrasena varchar(20) not null,
fecha_creacion date,
id_tipo int not null
)
/*Version MySQL*/
create table usuario
(id_usuario int AUTO_INCREMENT primary key,
usuario varchar(20) not null,
contrasena varchar(20) not null,
fecha_creacion date,
id_tipo int not null
)
/*Datos a ingresar por defecto*/
insert into usuario values(0,'admin','admin',CURRENT_DATE)
/*----------------*/
go
/*Tabla de Tipo de Usuario*/
create table tipo
(id_tipo int identity(1,1) primary key,
nombre varchar(20) not null
)
/*Version MySQL*/
create table tipo
(id_tipo int AUTO_INCREMENT primary key,
nombre varchar(20) not null
)
/*Datos a ingresar por defecto*/
insert into tipo values(0,'Administrador');
insert into tipo values(0,'Doctor');
insert into tipo values(0,'Empleado');
/*-----------------*/
/*Tabla de Permiso*/
go
create table permiso
(id_permiso int identity(1,1) primary key,
nombre_externo varchar(50) not null,
nombre_interno varchar(50) not null
)
/*Version MySQL*/
create table permiso
(id_permiso int AUTO_INCREMENT primary key,
nombre_externo varchar(50) not null,
nombre_interno varchar(50) not null
)
/*Datos a ingresar por defecto*/
insert into permiso values(0,'Expedientes','adm_expedientes');
insert into permiso values(0,'Usuarios','adm_usuario');
/*-------------------*/
/*Tabla de Relacion entre tablas Tipo y Permiso*/
go
create table tipo_permiso
(id_tipo int not null,
id_permiso int not null,
foreign key(id_tipo) references tipo (id_tipo),
foreign key(id_permiso) references permiso (id_permiso)
)
/*Datos a ingresar por defecto*/
insert into tipo_permiso values(1,1);
insert into tipo_permiso values(1,2);
insert into tipo_permiso values(1,3);
insert into tipo_permiso values(2,1);
insert into tipo_permiso values(3,3);
/*-------------------*/
go
/*Tabla de expediente/perfil de persona*/
create table expediente
(id_expediente int identity(1,1) primary key,
nombres varchar(100) not null,
apellidos varchar(100) not null,
edad int not null,
fecha_creacion date,
comentario varchar(1000)
)
/*Version MySQL*/
create table expediente
(id_expediente int AUTO_INCREMENT primary key,
nombres varchar(100) not null,
apellidos varchar(100) not null,
edad int not null,
fecha_creacion date,
comentario varchar(1000)
)
/*---------------------*/
go
/*Tabla de Visita en relacion al Expediente y Usuario*/
create table visita
(id_visita int identity(1,1) primary key,
fecha date,
comentario varchar(5000),
id_expediente int not null,
id_usuario int not null,
foreign key(id_expediente) references expediente(id_expediente),
foreign key(id_usuario) references usuario(id_usuario)
)
go
/*Version MySQL*/
create table visita
(id_visita int AUTO_INCREMENT primary key,
fecha date,
comentario varchar(5000),
id_expediente int not null,
id_usuario int not null,
foreign key(id_expediente) references expediente(id_expediente),
foreign key(id_usuario) references usuario(id_usuario)
)
go
/*--------------------------*/
/*Tabla para Turnos/Horarios de Usuarios*/
create table turno
(id_turno int identity(1,1) primary key,
id_usuario int not null,
fecha date,
hora_inicial time,
hora_final time,
foreign key(id_usuario) references usuario(id_usuario)
)
/*Version MySQL*/
create table turno
(id_turno int AUTO_INCREMENT primary key,
id_usuario int not null,
fecha date,
hora_inicial time,
hora_final time,
foreign key(id_usuario) references usuario(id_usuario)