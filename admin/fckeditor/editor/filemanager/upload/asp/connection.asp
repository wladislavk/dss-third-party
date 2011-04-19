<%
	'''''''Open a connection to the database''''''''''''''''''''''''''''''''''	
	Dim MPath,intOcc,DBPath,DBTemp
	DBTemp = "Admin\Rp\Mall.mdb"
	MPath = Server.MapPath("index1.asp")
	intOcc = Instr(1,MPath,"index1.asp",1)	
	DBPath = Left(MPath,intOcc-1) & DBTemp 
	Dim Conn,ConnStr,adModeReadWrite,adOpenDynamic,adLockOptimistic,adUseClient
	adLockOptimistic = 3
	adOpenDynamic = 2
	adModeReadWrite = 3
	adUseClient = 3
	Set Conn = Server.CreateObject("ADODB.Connection")
	Conn.Mode = adModeReadWrite
	ConnStr = "DBQ=" & DBPath & ";Driver={Microsoft Access Driver (*.mdb)};"
	Conn.ConnectionString = ConnStr
	Conn.CursorLocation = adUseClient
	Conn.Open
	'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
%>