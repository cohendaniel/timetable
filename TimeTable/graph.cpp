#include "graph.h"

Graph::Graph(int numNodes) {
	numNodes_ = numNodes;
	for (int i = 0; i < numNodes_; i++) {
		std::vector<int> row(numNodes_);
		graph.push_back(row);
	}
	source = std::shared_ptr<Node>(new Node);
	sink = std::shared_ptr<Node>(new Node);
}

void Graph::addItem(Item &item) {
	std::shared_ptr<ItemNode> newItemNode(new ItemNode(item));
	itemNodes.push_back(newItemNode);
	addDups(newItemNode);
	for (int b = 0; b < NUMBLOCKS; b++) {
		if (item.avail[b]) {
			addEdge(newItemNode, blockNodes[b]);
		}
	}
}

//numDups start at 0 or 1?
void Graph::addDups(std::shared_ptr<ItemNode> itemNode) {
	for (int d = 0; d < itemNode->nItem.numDups; d++) {
		std::shared_ptr<DupNode> newDupNode(new DupNode(itemNode));
		addEdge(newDupNode, itemNode);
		addEdge(source, newDupNode);
		dupNodes.push_back(newDupNode);
		itemNode->dups.push_back(newDupNode);
	}
}

void Graph::addBlock(Block &block) {
	std::shared_ptr<BlockNode> newBlockNode(new BlockNode(block));
	blockNodes.push_back(newBlockNode);
	addSlots(newBlockNode);
}

void Graph::addSlots(std::shared_ptr<BlockNode> blockNode) {
	for (int s = 0; s < blockNode->nBlock.numSlots; s++) {
		std::shared_ptr<SlotNode> newSlotNode(new SlotNode(blockNode));
		addEdge(blockNode, newSlotNode);
		addEdge(newSlotNode, sink);
		slotNodes.push_back(newSlotNode);
	}
}

void Graph::addEdge(std::shared_ptr<Node> nodeFrom, std::shared_ptr<Node> nodeTo) {
	graph[nodeFrom->ID()][nodeTo->ID()] = 1;
	nodeFrom->neighbors.push_back(nodeTo);
	nodeTo->neighbors.push_back(nodeFrom);
}

int Graph::getEdgeWeight(std::shared_ptr<Node> nodeFrom, std::shared_ptr<Node> nodeTo) {
	return graph[nodeFrom->ID()][nodeTo->ID()];
}

void Graph::setEdgeWeight(std::shared_ptr<Node> nodeFrom, std::shared_ptr<Node> nodeTo, int weight) {
	graph[nodeFrom->ID()][nodeTo->ID()] = weight;
}

void Graph::resetColor() {
	for (int i = 0; i < dupNodes.size(); i++) {
		dupNodes[i]->setColor(Node::white);
	}
	for (int i = 0; i < itemNodes.size(); i++) {
		itemNodes[i]->setColor(Node::white);
	}
	for (int i = 0; i < blockNodes.size(); i++) {
		blockNodes[i]->setColor(Node::white);
	}
	for (int i = 0; i < slotNodes.size(); i++) {
		slotNodes[i]->setColor(Node::white);
	}
	source->setColor(Node::white);
	sink->setColor(Node::white);
}

int Graph::size() {
	return numNodes_;
}

void Graph::printGraph() {
	for (unsigned int i = 0; i < graph.size(); i++) {
		for (unsigned int j = 0; j < graph.size(); j++) {
			std::cout << graph[i][j] << " ";
		}
		std::cout << std::endl;
	}
}