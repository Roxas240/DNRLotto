package com.xemplar.utils.dnrlotto.server.jsonrpc.client;

import com.xemplar.utils.dnrlotto.server.CommunicationException;
import com.xemplar.utils.dnrlotto.server.CryptocoinException;
import com.xemplar.utils.dnrlotto.server.jsonrpc.JsonMapper;
import com.xemplar.utils.dnrlotto.server.jsonrpc.JsonPrimitiveParser;

import java.util.List;

public interface JsonRpcClient {
	public abstract String execute(String method) throws CryptocoinException, CommunicationException;
	public abstract <T> String execute(String method, T param) throws CryptocoinException, CommunicationException;
	public abstract <T> String execute(String method, List<T> params) throws CryptocoinException,  CommunicationException;
	
	JsonPrimitiveParser getParser();
	JsonMapper getMapper();
	
	void close();
}