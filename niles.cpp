#include <iostream>
#include <string>
#include <cstring>
#include <sstream>
#include <iomanip>
#include <sys/socket.h>
#include <netinet/in.h>
#include <arpa/inet.h>
#include <stdio.h>
#include <stdlib.h>
#include <unistd.h>
#include <errno.h>
#include <sys/types.h>

using namespace std;

int main()
{
    string result;
    string word[10];
    char zoneid = 0x00;
    char inputid = 0x00;
    int i, j, k ,l;
    char outbuffer[] = {0x00, 0x12, 0x00, zoneid, 0x00, 0x0b, 0x61, 0x06, inputid, 0x00, 0xff};
    char zones[] = {0x21, 0x22, 0x23, 0x24, 0x25, 0x26};
    char inputs[] = {0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06};
    string nums[] = {"0", "1", "2", "3", "4", "5", "6"};
    int zoneindex, inputindex;
    

    int sendfd = 0,connfd = 0;
  
    struct sockaddr_in serv_addr;

    sendfd = socket(AF_INET, SOCK_DGRAM, 0);
    serv_addr.sin_family = AF_INET;    
    serv_addr.sin_addr.s_addr = inet_addr("10.100.0.1");
    serv_addr.sin_port = htons(6001);    
    bind(sendfd, (struct sockaddr*)&serv_addr,sizeof(serv_addr));

    i=1;
    while (i==1)
    {
        cout << endl <<"Enter Command: " << endl;
        getline(cin, result);
        stringstream iss(result);
        j=0;
        while (iss >> word[j])
        {
            cout << word[j] <<endl;
            j++;
        }
        if((word[0] == "Zone") && (word[2] == "Input"))
        {
            for(k=0; k<=6; k++)
            {
                if (word[1] == nums[k])
                {
                    zoneindex = k-1;  // adjust zone index to start at zero
                }
                if (word[3] == nums[k])
                {
                    inputindex = k;
                }
            }
            printf("%d   %d\n", zoneindex, inputindex);
            outbuffer[3] = zones[zoneindex];
            outbuffer[8] = inputs[inputindex];
            sendto(sendfd,outbuffer,sizeof(outbuffer),0,(struct sockaddr *)&serv_addr,sizeof(serv_addr));
    
        }
        else
        {
            i=0;
        }
    }
    
    close(sendfd);    
    
    return (0);
}
