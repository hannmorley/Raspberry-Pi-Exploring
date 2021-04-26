#include <stdio.h>
#include <python2.7/Python.h>
// Use this command to compile me: gcc cwrapper.c -I/usr/include/python2.7 -lpython2.7

int main()
{
	char filename[] = "rpi_voice_control1.py";
	FILE* fp;

	Py_Initialize();

	fp = fopen(filename, "r");
	PyRun_SimpleFile(fp, filename);

	Py_Finalize();
	return 0;
}
