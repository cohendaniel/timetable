#pragma once

void initConstants();
void fillGraph(Graph &g);
void findMatches(Graph &g);
void readBlockFile(char* blockFile, Graph &g);
void readItemFile(char* itemFile, Graph &g);