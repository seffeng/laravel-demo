<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: app/Grpc/Protos/Demo.proto

namespace App\Grpc\GPBMetadata;

class Demo
{
    public static $is_initialized = false;

    public static function initOnce() {
        $pool = \Google\Protobuf\Internal\DescriptorPool::getGeneratedPool();

        if (static::$is_initialized == true) {
          return;
        }
        $pool->internalAddGeneratedFile(
            '
�
app/Grpc/Protos/Demo.proto"(
DemoRequest
name (	
age ("S
DemoInfoReply
code (
status (	
message (	
data (2.Data"W
DemoListReply
code (
status (	
message (	
data (2	.DataList"8
Data

id (
name (	
age (2	.DataType"5
DataList
items (2.Data
page (2.Page"S
Page

totalCount (
currentPage (
	pageCount (
perPage ("$
DataType

id (
name (	2V
Demo&
view.DemoRequest.DemoInfoReply" &
list.DemoRequest.DemoListReply" B\'�App\\Grpc\\Demo�App\\Grpc\\GPBMetadatabproto3'
        , true);

        static::$is_initialized = true;
    }
}

