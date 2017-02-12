#pragma once

void initConstants(int d, int i, int b, int s);
void fillGraph(Graph &g, char* blockFile, char* itemFile);
void findMatches(Graph &g);
void readBlockFile(char* blockFile, Graph &g);
void readItemFile(char* itemFile, Graph &g);