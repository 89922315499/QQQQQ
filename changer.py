import pymysql
from tkinter import Tk,Label,Entry,Button

con = pymysql.connect('localhost', 'mysql', 'mysql', 'database')

get_info = open('file.txt','r')
data = get_info.read().split() # массив из двух элементов, первый - id, второй - таблица
get_info.close()
del_info = open('file.txt','w') 
del_info.write('')
del_info.close()


spacenames = {'id_customers':'ID Покупателя','second_name':'Фамилия','middle_name':'Отчество',
'date_of_birth':'Дата рождения','sex':'Пол','phone':'Телефон','email':'e-mail','notes':'Примечание',
'id_service':'ID товара','view':'Марка товара','model':'Модель товара','retail_price':'Стоимость услуги','city':'Город',
'id_sale':'ID продажи', 'id_staff':'ID сотрудника','date_of_sale':'Дата продажи','payment_method':'Способ оплаты',
'pricetag':'Сумма сделки','position':'Должность', 'date_of_employment':'Дата трудоустройства','entity':'Срок договора','first_name':'Имя','expiration':'Лицо'}

with con:
	cur = con.cursor()
	cur.execute('SELECT * from {} WHERE id_{}={}'.format(data[1],data[1],data[0]))
	version = cur.fetchall()
	cur.execute('DESC {};'.format(data[1]))
	cur.execute('SHOW COLUMNS FROM {};'.format(data[1]))
	names = cur.fetchall()

to_modify = [] # НАЗВАНИЕ ПОЛЕЙ

def cascade_place(modify):
	if modify>0:
		Label(font='Arial 14', text = spacenames.get(names[1][0]), bg='#242424',fg='#e4e4e4').place(anchor='center', relx=0.5,rely=0.05)
		to_modify.append(names[1][0])
		field1.place(anchor='center', relx=0.5,rely=0.1)
		field1.insert(0, version[0][1])
	if modify>1:
		Label(font='Arial 14', text = spacenames.get(names[2][0]), bg='#242424',fg='#e4e4e4').place(anchor='center', relx=0.5,rely=0.15)
		to_modify.append(names[2][0])
		field2.place(anchor='center', relx=0.5,rely=0.2)
		field2.insert(0, version[0][2])
	if modify>2:
		Label(font='Arial 14', text = spacenames.get(names[3][0]), bg='#242424',fg='#e4e4e4').place(anchor='center', relx=0.5,rely=0.25)
		to_modify.append(names[3][0])
		field3.place(anchor='center', relx=0.5,rely=0.3)
		field3.insert(0, version[0][3])
	if modify>3:
		Label(font='Arial 14', text = spacenames.get(names[4][0]), bg='#242424',fg='#e4e4e4').place(anchor='center', relx=0.5,rely=0.35)
		to_modify.append(names[4][0])
		field4.place(anchor='center', relx=0.5,rely=0.4)
		field4.insert(0, version[0][4])
	if modify>4:
		Label(font='Arial 14', text = spacenames.get(names[5][0]), bg='#242424',fg='#e4e4e4').place(anchor='center', relx=0.5,rely=0.45)
		to_modify.append(names[5][0])
		field5.place(anchor='center', relx=0.5,rely=0.5)
		field5.insert(0, version[0][5])
	if modify>5:
		Label(font='Arial 14', text = spacenames.get(names[6][0]), bg='#242424',fg='#e4e4e4').place(anchor='center', relx=0.5,rely=0.55)
		to_modify.append(names[6][0])
		field6.place(anchor='center', relx=0.5,rely=0.6)
		field6.insert(0, version[0][6])
	if modify>6:
		Label(font='Arial 14', text = spacenames.get(names[7][0]), bg='#242424',fg='#e4e4e4').place(anchor='center', relx=0.5,rely=0.65)
		to_modify.append(names[7][0])
		field7.place(anchor='center', relx=0.5,rely=0.7)
		field7.insert(0, version[0][7])
	if modify>6:
		Label(font='Arial 14', text = spacenames.get(names[8][0]), bg='#242424',fg='#e4e4e4').place(anchor='center', relx=0.5,rely=0.75)
		to_modify.append(names[8][0])
		field8.place(anchor='center', relx=0.5,rely=0.8)
		field8.insert(0, version[0][8])
	if modify>8:
		Label(font='Arial 14', text = spacenames.get(names[9][0]), bg='#242424',fg='#e4e4e4').place(anchor='center', relx=0.5,rely=0.85)
		to_modify.append(names[9][0])
		field9.place(anchor='center', relx=0.5,rely=0.9)
		field9.insert(0, version[0][9])


root = Tk()
root.geometry('500x700+500-160')
root.resizable(0,0)
root.overrideredirect(True)
root.focus_force()
root.attributes('-topmost', True)
root['bg']='#242424'



e_cas=[]
def up_d(event):
	modify = len(version[0])-1
	if modify>0:
		e_cas.append(field1.get())
	if modify>1:
		e_cas.append(field2.get())
	if modify>2:
		e_cas.append(field3.get())
	if modify>3:
		e_cas.append(field4.get())
	if modify>4:
		e_cas.append(field5.get())
	if modify>5:
		e_cas.append(field6.get())
	if modify>6:
		e_cas.append(field7.get())
	if modify>7:
		e_cas.append(field8.get())
	if modify>8:
		e_cas.append(field9.get())

	with con:
		for i in range(0,modify):
			cur.execute('UPDATE {} SET {} = "{}" WHERE id_{} = {}'.format( data[1], to_modify[i] , e_cas[i], data[1], data[0] )  )

	root.destroy()



field1 = Entry(root,width=30,font='Arial 14', border=0, bg='#323232',fg='#e4e4e4')

field2 = Entry(root,width=30,font='Arial 14', border=0,bg='#323232',fg='#e4e4e4')

field3 = Entry(root,width=30,font='Arial 14', border=0,bg='#323232',fg='#e4e4e4')

field4 = Entry(root,width=30,font='Arial 14', border=0,bg='#323232',fg='#e4e4e4')

field5 = Entry(root,width=30,font='Arial 14', border=0,bg='#323232',fg='#e4e4e4')

field6 = Entry(root,width=30,font='Arial 14', border=0,bg='#323232',fg='#e4e4e4')

field7 = Entry(root,width=30,font='Arial 14', border=0,bg='#323232',fg='#e4e4e4')

field8 = Entry(root,width=30,font='Arial 14', border=0,bg='#323232',fg='#e4e4e4')

field9 = Entry(root,width=30,font='Arial 14', border=0,bg='#323232',fg='#e4e4e4')

Go=Button(root,text='Изменить', width = 8, height=2, bg='#323232',fg='#e4e4e4', border=0)
Go.place(anchor='center', relx=0.6,rely=0.95)
Go.bind('<1>',up_d)

Ex=Button(root,text='Отмена', width = 8, height=2, bg='#323232',fg='#e4e4e4', border=0)
Ex.place(anchor='center', relx=0.4,rely=0.95)
Ex.bind('<1>',up_d)

cascade_place(len(version[0])-1)



root.mainloop()
